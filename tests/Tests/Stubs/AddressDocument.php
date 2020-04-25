<?php

namespace Xenus\Tests\Tests\Stubs;

class AddressDocument extends \Xenus\Document
{
    protected $withId = true;

    public function getUser()
    {
        return $this->belongsTo(UsersCollection::class, 'user_id');
    }

    public function getUsers()
    {
        return $this->belongsToMany(UsersCollection::class, 'users_id');
    }
}
