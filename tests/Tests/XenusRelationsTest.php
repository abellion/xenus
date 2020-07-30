<?php

namespace Xenus\Tests\Tests;

use Xenus\Tests\Stubs\AddressDocument as Address;
use Xenus\Tests\Stubs\AddressesCollection as Addresses;

use Xenus\Tests\Stubs\UserDocument as User;
use Xenus\Tests\Stubs\UsersCollection as Users;

use Xenus\Tests\Support\SetupRelationsTest;

class XenusRelationsTest extends \PHPUnit\Framework\TestCase
{
    use SetupRelationsTest;

    public function test_find_method_in_has_one_relationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['user_id' => $user['_id']]))->connect($this->addresses)
        );

        $this->assertInstanceOf(
            Address::class, $user->getAddress()->find()
        );

        $this->assertEquals(
            (string) $address['_id'], (string) $user->getAddress()->find()['_id']
        );
    }

    public function test_find_method_in_has_many_relationship()
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

        $this->assertInstanceOf(
            \Traversable::class, $user->getAddresses()->find()
        );

        $addresses = $user->getAddresses()->find()->toArray();

        $this->assertEquals(
            (string) $addressA['_id'], (string) $addresses[0]['_id']
        );

        $this->assertEquals(
            (string) $addressB['_id'], (string) $addresses[1]['_id']
        );
    }

    public function test_find_one_method_in_has_many_relationship()
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

        $this->assertEquals(
            'Paris', $paris['city']
        );

        $tours = $user->getAddresses()->findOne(['city' => 'Tours']);

        $this->assertEquals(
            'Tours', $tours['city']
        );
    }

    public function test_distinct_mehtod_in_has_many_relationship()
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

        $this->assertEquals(
            ['Paris', 'Tours'], $cities
        );
    }

    public function test_find_method_in_belongs_to_relationship()
    {
        $this->users->insert(
            $user = (new User())->connect($this->users)
        );

        $this->addresses->insert(
            $address = (new Address(['user_id' => $user['_id']]))->connect($this->addresses)
        );

        $this->assertInstanceOf(
            User::class, $address->getUser()->find()
        );

        $this->assertEquals(
            (string) $user['_id'], (string) $address->getUser()->find()['_id']
        );
    }

    public function test_find_method_in_belongs_to_many_relationship()
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

        $this->assertInstanceOf(
            \Traversable::class, $address->getUsers()->find()
        );

        $users = $address->getUsers()->find()->toArray();

        $this->assertEquals(
            (string) $userA['_id'], (string) $users[0]['_id']
        );

        $this->assertEquals(
            (string) $userB['_id'], (string) $users[1]['_id']
        );
    }


    public function test_count_method_in_belongs_to_many_relationship()
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

        $this->assertEquals(
            2, $count
        );
    }

    public function test_find_one_method_in_belongs_to_many_relationship()
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

        $this->assertEquals(
            'Antoine', $antoine['name']
        );

        $nicolas = $address->getUsers()->findOne(['name' => 'Nicolas']);

        $this->assertEquals(
            'Nicolas', $nicolas['name']
        );
    }

    public function test_distinct_method_in_belongs_to_many_relationship()
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

        $this->assertEquals(
            ['Antoine', 'Nicolas'], $names
        );
    }
}
