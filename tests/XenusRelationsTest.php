<?php

namespace Xenus\Tests;

use Xenus\Tests\Stubs\AddressDocument as Address;
use Xenus\Tests\Stubs\AddressesCollection as Addresses;

use Xenus\Tests\Stubs\UserDocument as User;
use Xenus\Tests\Stubs\UsersCollection as Users;

use PHPUnit\Framework\TestCase;

class XenusRelationsTest extends TestCase
{
    use Cases\RefreshDatabase;

    private $users;
    private $addresses;

    public function setUp()
    {
        $this->createDatabase();

        $this->users = new Users($this->database);
        $this->addresses = new Addresses($this->database);
    }

    public function testOneToOneRelationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['user_id' => $user['_id']]))->connect($this->addresses)
        );

        $this->assertInstanceOf(\Xenus\Relations\BindOne::class, $user->getAddress());
        $this->assertInstanceOf(\Xenus\Relations\BindOne::class, $address->getUser());

        $this->assertInstanceOf(User::class, $address->getUser()->find());
        $this->assertInstanceOf(Address::class, $user->getAddress()->find());
    }
}
