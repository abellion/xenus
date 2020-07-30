<?php

namespace Xenus\Tests\Stubs;

class UsersCollection extends \Xenus\Collection
{
    protected $name = 'users';
    protected $document = UserDocument::class;
}

