<?php

namespace Xenus\Tests\Unit;

use Xenus\Cursor;

use Xenus\Tests\Unit\Stubs\AddressDocument as Address;
use Xenus\Tests\Unit\Stubs\AddressesCollection as Addresses;

use Xenus\Tests\Unit\Stubs\UserDocument as User;
use Xenus\Tests\Unit\Stubs\UsersCollection as Users;

use Xenus\Tests\Support\RefreshDatabase;

class XenusRelationsTest extends \PHPUnit\Framework\TestCase
{
    use RefreshDatabase;

    private $users;
    private $addresses;

    public function setUp()
    {
        $this->createDatabase();

        $this->users = new Users($this->database);
        $this->addresses = new Addresses($this->database);
    }

    public function testCursorConnection()
    {
        $users = (new Cursor(new \ArrayIterator([
            new User(),
            new User()
        ])))->toArray();

        $this->assertNull($users[0]->collection());
        $this->assertNull($users[1]->collection());

        $users = (new Cursor(new \ArrayIterator([
            new User(),
            new User()
        ])))->connect($this->users)->toArray();

        $this->assertSame($users[0]->collection(), $this->users);
        $this->assertSame($users[1]->collection(), $this->users);
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

    public function testFindOneInHasManyRelationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $addressA = (new Address(['user_id' => $user['_id'], 'city' => 'Paris']))->connect($this->addresses)
        );

        $this->addresses->insert(
            $addressB = (new Address(['user_id' => $user['_id'], 'city' => 'Tours']))->connect($this->addresses)
        );

        $paris = $user->getAddresses()->findOne(['city' => 'Paris']);

        $this->assertEquals('Paris', $paris['city']);

        $tours = $user->getAddresses()->findOne(['city' => 'Tours']);

        $this->assertEquals('Tours', $tours['city']);
    }

    public function testDistinctInHasManyRelationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $addressA = (new Address(['user_id' => $user['_id'], 'city' => 'Paris']))->connect($this->addresses)
        );

        $this->addresses->insert(
            $addressB = (new Address(['user_id' => $user['_id'], 'city' => 'Tours']))->connect($this->addresses)
        );

        $cities = $user->getAddresses()->distinct('city');

        $this->assertEquals(['Paris', 'Tours'], $cities);
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

    public function testBelongsToManyRelationship()
    {
        $this->users->insert(
            $userA = (new User())->connect($this->users)
        );

        $this->users->insert(
            $userB = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['users_id' => [$userA['_id'], $userB['_id']]]))->connect($this->addresses)
        );

        $this->assertInstanceOf(\Xenus\Relations\BindMany::class, $address->getUsers());
        $this->assertInstanceOf(\Traversable::class, $address->getUsers()->find());

        $users = $address->getUsers()->find()->toArray();

        $this->assertEquals((string) $userA['_id'], (string) $users[0]['_id']);
        $this->assertEquals((string) $userB['_id'], (string) $users[1]['_id']);
    }

    public function testCountInBelongsToManyRelationship()
    {
        $this->users->insert(
            $userA = (new User(['name' => 'Antoine']))->connect($this->users)
        );

        $this->users->insert(
            $userB = (new User(['name' => 'Nicolas']))->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['users_id' => [$userA['_id'], $userB['_id']]]))->connect($this->addresses)
        );

        $count = $address->getUsers()->count();

        $this->assertEquals(2, $count);
    }

    public function testFindOneInBelongsToManyRelationship()
    {
        $this->users->insert(
            $userA = (new User(['name' => 'Antoine']))->connect($this->users)
        );

        $this->users->insert(
            $userB = (new User(['name' => 'Nicolas']))->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['users_id' => [$userA['_id'], $userB['_id']]]))->connect($this->addresses)
        );

        $antoine = $address->getUsers()->findOne(['name' => 'Antoine']);

        $this->assertEquals('Antoine', $antoine['name']);

        $nicolas = $address->getUsers()->findOne(['name' => 'Nicolas']);

        $this->assertEquals('Nicolas', $nicolas['name']);
    }

    public function testDistinctInBelongsToManyRelationship()
    {
        $this->users->insert(
            $userA = (new User(['name' => 'Antoine']))->connect($this->users)
        );

        $this->users->insert(
            $userB = (new User(['name' => 'Nicolas']))->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['users_id' => [$userA['_id'], $userB['_id']]]))->connect($this->addresses)
        );

        $names = $address->getUsers()->distinct('name');

        $this->assertEquals(['Antoine', 'Nicolas'], $names);
    }
}
