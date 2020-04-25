<?php

namespace Xenus\Tests\Tests\Stubs;

class UserDocument extends \Xenus\Document
{
    protected $withId = true;

    public function getAddress()
    {
        return $this->hasOne(AddressesCollection::class, 'user_id');
    }

    public function getAddresses()
    {
        return $this->hasMany(AddressesCollection::class, 'user_id');
    }
}

