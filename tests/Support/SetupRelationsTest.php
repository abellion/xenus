<?php

namespace Xenus\Tests\Support;

use Xenus\Tests\Unit\Stubs\UsersCollection as Users;
use Xenus\Tests\Unit\Stubs\AddressesCollection as Addresses;

trait SetupRelationsTest
{
    use RefreshDatabase;

    private $addresses;

    private $users;

    public function setUp()
    {
        $this->createDatabase();

        $this->addresses = new Addresses($this->database);

        $this->users = new Users($this->database);
    }
}
