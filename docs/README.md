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

To create a new user, simply instantiate the `User` object, optionnaly with a set of properties :

```php
//Create an empty user, and then gives him a name
$john = new User();
$john->name = 'John';

//Create directly the user with a name
$john = new User(['name' => 'John']);
```

When retrieving models, you'll receive an instance of a `Xenus\Document` class by default. To tell Xenus to use a custom document, you need to set a protected property called `doument` in the `Collection` class :

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

On top of that, a document offers you three methods `get()`, `set()` and `has()` to work in a more OOP way :

```php
//Return a boolean
$user->has('name');

//Return the document's name value
$user->get('name');

//Set the document's name value and return the instance
$user->set('name', $name);
```

If you want to validate the data before setting it, or tweak the data before getting it, you can declare a set of accessors (a getter and a setter) in your models.

Doing this way has several advantages :

- At first glance you can see what's inside a model
- You can take advantage of PHP type-hint to validate the input
- You can tweak the data (like applying a `trim()`)

```php
use Xenus\Document;

class User extends Document
{
    public function getName()
    {
        return $this->get('name');
    }

    public function setName(string $name)
    {
        return $this->set('name', trim($name));
    }
}
```

When mutating a document, Xenus will try to find the corresponding getter and setter for you so you don't have to use the quite verbose `setXXX()` and `getXXX` methods.

- A getter is a method whose name starts with `get` and its followed by the property name.
- A setter is a method whose name starts with `set` and its followed by the property name.

!> This "auto discovery" mechanism is not used if you use the array form (ie. `$model['property']`) to keep a way of muttating the documents without using the accessors.

Of course, as well as these accessors, you can add some other methods serving your business logic.

```php
use Xenus\Document;

class User extends Document
{
    public function isAdult()
    {
        return $this->get('age') >= 21;
    }
}
```

### Embedded documents

One super feature of MongoDB is the ability to nest data within documents. For example, a user could have some contact informations (phone number, address, ...) stored as a document :

```php
use Xenus\Document;

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

You'll find the `Embed` utility in the `Xenus\Support` namespace to easily embed documents within models :

- `Embed::document(Contact::class)->on($contact)` : It makes the `$contact` array be an instance of the `Contact` document.

- `Embed::document(Contact::class)->in($contact)` : It makes every of the `$contact` values be an instance of the `Contact` document.

```php
use Xenus\Document;
use Xenus\Support\Embed;

class User extends Document
{
    public function getContacts()
    {
        return $this->get('contacts');
    }

    public function setContacts(array $contacts)
    {
        return $this->set('contacts', Embed::document(Contact::class)->in($contacts));
    }

    public function getPrimaryContact()
    {
        return $this->get('primary_contact');
    }

    public function setPrimaryContact($contact)
    {
        return $this->set('primary_contact', Embed::document(Contact::class)->on($contact));
    }
}
```

- The user's `contacts` value will be an array of `Contact` documents.
- The user's `primary_contact` value will be an instance of the `Contact` document.

> You could have the embedded documents definitions in the same file as the main model document. It's not PSR-4 compliant but it's worth having it at the same level for clarity.



