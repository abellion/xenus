# Getting started

__Xenus__ is a simple yet powerfull ODM for MongoDB. The motivation behind this project is to provide a simple interface between your database documents and your __PHP__ code.

This ODM uses the latest technologies such as PHP 7 and the new MongoDB driver, which are not supported by the others well known ODM.

## Installation

```bash
composer require abellion/xenus
```

Xenus requires PHP version 7.0 or higher and the MongoDB driver version 1.2 or higher.

Make sure to install first the MongoDB driver, otherwise composer will throw an error. Take a look at the driver documentation : http://php.net/manual/en/set.mongodb.php

## First steps

> This guide assumes you have an existing knowledge of the MongoDB library and driver.

- Driver documentation : http://php.net/manual/en/set.mongodb.php
- Library documentation : https://docs.mongodb.com/php-library/master/

We'll walk through the bacics CRUD operations across this guide. The only thing you have to do first is to establish a connection between your database and your PHP code.

```php
use MongoDB;

$client = new MongoDB\Client()

$database = $client->myDatabase;

```

> To know more about the `Client`, `Database` and `Collection` classes, please refer to the MongoDB library : https://docs.mongodb.com/php-library/master/reference/class/MongoDBClient/

# Guide

## Working with collections

One long-standing pattern about databases is to use some methods to grab the data you need instead of directly querying your database from your controllers.

Using this pattern has a lot of advantages :

- You don't need to know the internal working of a query
- You can easilly tweak a query from one single place
- ... and many more

### Creating a collection

Having a collection of users is very common, so let's take that as an example.
I usually put all my database business inside a `Model` folder. Let's create a `Users` class which will hold our methods :

```php
use Xenus\Collection;

class Users extends Collection
{
    //This is the name of your collection stored in your database
    protected $name = 'users';
}
```

A Xenus `Collection` needs two properties to work :

- To be constructed, an instance of the `MongoDB\Database` class
- And then, the name of the collection as a protected property

Instanciating this class can be done as follow :

```php
use MongoDB;

$client = new MongoDB\Client()
$database = $client->myDatabase;

$users = new Users($database);

```

> If you use a framework with a dependency injection container, you can configure it to automatically inject an instance of the `MongoDB\Database` in every collections.

### Querying the database

Every Xenus collection have an instance of the `MongoDB\Collection` class so you can query the database. The Xenus collection holds it as a protected property allowing you to easily retrieve the data from the database.

```php
//Get all the adult users
$adultUsers = $users->collection->find([
    'age' => ['$gte' => 21]
]);
```

Instead of making this query everywhere you need these users, you may better make a method inside the users class :

```php
use Xenus\Collection;

class Users extends Collection
{
    protected $name = 'users';

    public function findAdults(array $options = [])
    {
        return $this->collection->find([
            'age' => ['$gte' => 21]
        ], $options);
    }
}
```

```php
//The result will be the same but it seems cleaner, isn't it ?
$adultUsers = $users->findAdults();
```

> When creating a method you may find usefull to give an array of options if you want, for example, to sort the results.

```php
$adultUsers = $users->findAdults([
    'sort' => ['age' => 1]
]);
```

### CRUD helpers

Creating, Reading, Updating and Deleting a document is some operations you'll always do. Xenus provides a trait containing these four methods so you avoid writing them every time you create a collection.

```php
class Users extends Collection
{
    use Xenus\Collection\Collection\CRUDMethods;
}
```

```php
//Create
$john = new Xenus\Document(['name' => 'John']);
$users->insert($john);

//Retrieve
$john = $users->find(new MongoDB\BSON\ObjectID('...'));

//Update
$john->name = 'John Doe';
$users->update($john);

//Delete
$users->delete($john);
```

> The `Xenus\Document` class represents a document. We'll see that in a minute !

__CRUD summary :__

- `find(MongoDB\BSON\ObjectID $id, array $options = []): MongoDB\Driver\Cursor`
    - Retrieve a document
- `insert(Xenus\Document $document, array $options = []): MongoDB\InsertOneResult`
    - Insert a document
- `update(Xenus\Document $document, array $options = []): MongoDB\UpdateResult`
    - Update a document
- `delete(Xenus\Document $document, array $options = []): MongoDB\DeleteResult`
    - Delete a document

## Working with documents

Instead of receiving your data in the form of an array or a pristine object, Xenus allows you to treat your documents as pre-defined objects, containing a lot of helpful methods.

### Creating a document

A document is no more than a class containing your document's properties stored in your MongoDB database.
A user document may contains a `name`, an `email`, a `username` or whatever is fitting your business.

```php
use Xenus\Document;

class User extends Document
{
}
```

To create a new user you simply need to instantiate your `User` object, optionnaly with a set of properties :

```php
//Create an empty user, and then gives him a name
$john = new User();
$john->name = 'John';

//Create directly the user with a name
$john = new User(['name' => 'John']);
```

Xenus cannot guesses what document to use when fetching your data from the database. By default it uses the `Xenus\Collection` class. So you need to teach him how to _unserialize_ them, by setting a protected property called `doument` in your `Collection` class :

```php
use Xenus\Collection;

class Users extends Collection
{
    protected $name = 'users';
    protected $document = User::class;
}
```

From now, whenever you'll fetch some users, they will come in the form of the `User` class.

### Accessing properties

The `Xenus\Document` class implements the `ArrayAccess` interface and uses the magic methods `__get` and `__set`. You can access your document's properties using these ways :

```php
//Get the user name
$user->name;
$user['name'];

//Set the user name
$user->name = 'John';
$user['name'] = 'John';
```

Both, using the array form or the magic methods, behaves exactly the same currently but there is a difference ! When using the dynamic form Xenus will try to find a getter or a setter method in your document.

If it cannot figure out a getter or a setter method, it will read or write the data directly from the internal array storing the user properties. On the opposite, if it finds one of these methods, it will use them to mutate your document.

```php
use Xenus\Document;

class User extends Document
{
    public function getName()
    {
        //Get `name` from the internal array
        return $this->get('name');
    }

    public function setName(string $name)
    {
        //Get `name` to the internal array
        return $this->set('name', trim($name));
    }
}
```

Declaring a set of getters and setters in your documents has several advantages :

- At first glance you can see what's inside
- You can take advantage of PHP type-hint
- You can tweak your data (we trimmed the name in the example above)

> To deal with your document's data, Xenus store them in an array called `document`. To avoid writing the same code in every getter or setter, you can take advantage of the `get` and `set` methods that provide a fluent way to access this internal array.

Of course, as well as your getters and setters, you can add some other methods serving your business logic.

```php
use Xenus\Document;

class User extends Document
{
    //...

    public function isAdult()
    {
        //You could also use the get method as well : $this->get('age') ...
        return $this->document['age'] >= 21;
    }
}
```

### Embedded documents

One super feature of MongoDB is the ability to nest your data within your documents. For example, you could have an array of addresses and another containing the user's contact informations. Embeding these properties as arrays would work, but don't you think it would be better to use a document object ?

To make your life easier, Xenus has a helper to easily get that done, in an elegant way.

__First case : embeding a document :__

```php
use Xenus\Document;

class User extends Document
{
    public function getContact()
    {
        return $this->get('contact');
    }

    public function setContact($contact)
    {
        //We tell Xenus to use the Contact class below to store the contact informations.

        //It will create an instance of `Contact` for you and put it in
        //your document with the "contact" key !
        return $this->embed(Contact::class)->on($contact)->as('contact');
    }
}

class Contact extends Document
{
    public function getPhoneNumber()
    {
        return $this->get('phone_number');
    }

    public function setPhoneNumber($phoneNumber)
    {
        return $this->set('phone_number', $phoneNumber);
    }

    //...
}
```

__Second case : embeding an array of documents :__

```php
use Xenus\Document;

class User extends Document
{
    public function getAddresses()
    {
        return $this->get('addresses');
    }

    public function setAddresses(array $addresses)
    {
        //Notice the difference : here we use the `in` method (instead of the `on`).

        //It behaves exactly the same as above, except that it loops
        //over the array for creating the addresses
        return $this->embed(Address::class)->in($addresses)->as('addresses');
    }
}

class Address extends Document
{
    public function getCity()
    {
        return $this->get('city');
    }

    public function setCity(string $city)
    {
        return $this->set('city', $city);
    }

    //...
}
```

__Examples :__

```php
//Retrieve the phone number passing through the contact document
$phoneNumber = $john->contact->phoneNumber;

//Retrieve john's cities. By the way, this one is a good candidate
//to take place as a method in the document class !
$cities = array_map(function ($address) {
    return $address->city;
}, $john->addresses);
```

> As you may notice in the examples above, the embedded documents are in the same file as the main one. This does not complain with PSR-4 but it's worth having it at the same level for clarity.



