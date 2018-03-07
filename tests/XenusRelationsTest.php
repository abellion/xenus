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

        $this->assertEquals((string) $user['_id'], (string) $address->getUser()->find()['_id']);
        $this->assertEquals((string) $address['_id'], (string) $user->getAddress()->find()['_id']);
    }

    public function testOneToManyRelationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $addressA = (new Address(['user_id' => $user['_id']]))->connect($this->addresses)
        );

        $this->addresses->insert(
            $addressB = (new Address(['user_id' => $user['_id']]))->connect($this->addresses)
        );

        $this->assertInstanceOf(\Xenus\Relations\BindOne::class, $addressA->getUser());
        $this->assertInstanceOf(\Xenus\Relations\BindOne::class, $addressB->getUser());
        $this->assertInstanceOf(\Xenus\Relations\BindMany::class, $user->getAddresses());

        $this->assertInstanceOf(User::class, $addressA->getUser()->find());
        $this->assertInstanceOf(User::class, $addressB->getUser()->find());
        $this->assertInstanceOf(\Traversable::class, $user->getAddresses()->find());

        $this->assertEquals((string) $user['_id'], (string) $addressA->getUser()->find()['_id']);
        $this->assertEquals((string) $user['_id'], (string) $addressB->getUser()->find()['_id']);

        $addresses = $user->getAddresses()->find()->toArray();

        $this->assertEquals((string) $addressA['_id'], (string) $addresses[0]['_id']);
        $this->assertEquals((string) $addressB['_id'], (string) $addresses[1]['_id']);
    }
}
