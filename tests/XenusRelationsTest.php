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

    public function testHasOneRelationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['user_id' => $user['_id']]))->connect($this->addresses)
        );

        $this->assertInstanceOf(\Xenus\Relations\BindOne::class, $user->getAddress());
        $this->assertInstanceOf(Address::class, $user->getAddress()->find());

        $this->assertEquals((string) $address['_id'], (string) $user->getAddress()->find()['_id']);
    }

    public function testHasManyRelationship()
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

        $this->assertInstanceOf(\Xenus\Relations\BindMany::class, $user->getAddresses());
        $this->assertInstanceOf(\Traversable::class, $user->getAddresses()->find());

        $addresses = $user->getAddresses()->find()->toArray();

        $this->assertEquals((string) $addressA['_id'], (string) $addresses[0]['_id']);
        $this->assertEquals((string) $addressB['_id'], (string) $addresses[1]['_id']);
    }

    public function testBelongsToRelationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['user_id' => $user['_id']]))->connect($this->addresses)
        );

        $this->assertInstanceOf(\Xenus\Relations\BindOne::class, $address->getUser());
        $this->assertInstanceOf(User::class, $address->getUser()->find());

        $this->assertEquals((string) $user['_id'], (string) $address->getUser()->find()['_id']);
    }
}
