<?php

require 'vendor/autoload.php';

use Xenus\Connection;
use Xenus\Collection;
use Xenus\CollectionParameters;

use Xenus\Parameters;

$connection = new Connection('mongodb://xenus-mongo:27017/?serverSelectionTimeoutMS=100', 'xenus');

class Users extends Collection {
    protected $name = 'users';
}

dump(
    new Users($connection)
);
