<?php

namespace Xenus\Tests\Stubs;

class UserDocument extends \Xenus\Document
{
    protected $withId = true;

    public function getAddress()
    {
        return $this->hasOne(AddressesCollection::class, 'user_id');
    }
}

