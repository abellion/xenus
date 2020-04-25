<?php

namespace Xenus\Tests\Unit\Stubs;

class UsersCollection extends \Xenus\Collection
{
    protected $name = 'users';
    protected $document = UserDocument::class;
}

