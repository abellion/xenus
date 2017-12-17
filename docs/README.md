# Getting started

__Xenus__ is a simple yet powerfull ODM for MongoDB. It uses the latest technologies such as PHP 7 and the new MongoDB driver.

## Installation

Xenus requires PHP version 7.0 or higher and the MongoDB driver version 1.2 or higher.

Make sure to install first the MongoDB driver : http://php.net/manual/en/mongodb.installation.php

Once installed, run the following from your project root :

```bash
composer require abellion/xenus
```

## First steps

> This guide assumes you have an existing knowledge of the MongoDB library and driver.

- Driver documentation : http://php.net/manual/en/set.mongodb.php
- Library documentation : https://docs.mongodb.com/php-library/v1.2/

Before going further, make sure you have a running MongoDB server and a established connection with it :

```php
use MongoDB;

$client = new MongoDB\Client()

$database = $client->myDatabase;

```

> To know more about the `Client`, `Database` and `Collection` classes, please refer to the MongoDB library : https://docs.mongodb.com/php-library/v1.2/reference/class/MongoDBClient/

# Guide

## Collections

### Defining collections

Having a collection of users is very common, so let's take that as an example :

```php
use Xenus\Collection;

class Users extends Collection
{
    //This is the name of your collection stored in the database
    protected $name = 'users';
}
```

A Xenus `Collection` needs two properties to be constructed :

- An instance of the `MongoDB\Database` class,
- The name of the collection as a protected property.

```php
use MongoDB;

$client = new MongoDB\Client()
$database = $client->myDatabase;

$users = new Users($database);

```

> If you use a framework with a dependency injection container, you can configure it to automatically inject an instance of the `MongoDB\Database` in every collections.

### Retrieving documents

Collections inherit from the `MongoDB\Collection` class so you can use any of the methods provided by the MongoDB library : https://docs.mongodb.com/php-library/v1.2/reference/class/MongoDBCollection/

| Method | Description |
|--------|-------------|
| `find()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-find/ |
| `findOne()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-findOne/ |

```php
$adultUsers = $users->find([
    'age' => ['$gte' => 21]
]);
```

Instead of making this query everywhere you need these users, you may better make a method inside the users collection :

```php
use Xenus\Collection;

class Users extends Collection
{
    protected $name = 'users';

    public function findAdults(array $options = [])
    {
        return $this->find([
            'age' => ['$gte' => 21]
        ], $options);
    }
}
```

```php
$adultUsers = $users->findAdults();
```

> When creating a method you may find usefull to give an array of options if you want to sort the results for example.

```php
$adultUsers = $users->findAdults([
    'sort' => ['age' => 1]
]);
```

You'll see you very often retrieving models by ID typing `['_id' => $id]`. To avoid that, Xenus allows you to give directly a `MongoDB\BSON\ObjectID` instance that's automatically translated to the array form :

```php
// Typing
$users->findOne($id);
// Is the same as :
$users->findOne(['_id' => $id]);
```

### Inserting & Updating documents

The MongoDB library offers you some great methods to work with update and delete operations :

| Method | Description |
|--------|-------------|
| `insertOne()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-insertOne/ |
| `insertMany()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-insertMany/ |
| `updateOne()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-updateOne/ |
| `updateMany()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-updateMany/ |
| `deleteOne()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-deleteOne/ |
| `deleteMany()` | https://docs.mongodb.com/php-library/v1.2/reference/method/MongoDBCollection-deleteMany/ |

On top of these methods, Xenus provides some more natural `update()`, `delete()` and `insert()` methods to work with single documents. These methods take directly a document as parameter :

```php
$john = ['_id' => '...', 'name' => 'John'];

//Create
$users->insert($john);

//Update
$users->update($john);

//Delete
$users->delete($john);
```

Sometimes you don't want or need to retrieve a document before updating or deleting it, so you will use one of the `updateOne()` and `deleteOne()` methods. Because it's so common to use them with a single `_id` filter, Xenus offers you the possibility to give directly a `MongoDB\BSON\ObjectID` :

```php
//Update directly by ID
$users->updateOne($userId, [...]);

//Delete directly by ID
$users->deleteOne($userId)
```

## Documents

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

If it cannot figures out a getter or a setter method, it will read or write the data directly from the internal array storing the user properties. On the opposite, if it finds one of these methods, it will use them to mutate your document.

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
        //Set `name` to the internal array
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



