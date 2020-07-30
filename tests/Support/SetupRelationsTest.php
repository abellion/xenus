<?php

namespace Xenus\Tests\Support;

use Xenus\Tests\Tests\Stubs\UsersCollection as Users;
use Xenus\Tests\Tests\Stubs\AddressesCollection as Addresses;

trait SetupRelationsTest
{
    use SetupDatabase, SetupTestsHooks;

    private $setup = [
        'createDatabase', 'createAddressesCollection', 'createUsersCollection'
    ];

    private $tearDown = [
        'deleteDatabase'
    ];

    private $addresses;

    private $users;

    /**
     * Create the addresses collection
     *
     * @return void
     */
    private function createAddressesCollection()
    {
        $this->addresses = new Addresses($this->connection);
    }

    /**
     * Create the users collection
     *
     * @return void
     */
    private function createUsersCollection()
    {
        $this->users = new Users($this->connection);
    }
}
