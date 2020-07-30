<?php

namespace Xenus\Tests\Tests;

use Xenus\Cursor;
use Xenus\Connection;

use Xenus\Tests\Stubs\UserDocument as User;
use Xenus\Tests\Stubs\UsersCollection as Users;

class CursorTest extends \PHPUnit\Framework\TestCase
{
    public function test_cursor_connection()
    {
        $users = new \ArrayIterator([
            new User(),
            new User()
        ]);

        $users = (new Cursor($users))->toArray();

        $this->assertNull(
            $users[0]->collection()
        );

        $this->assertNull(
            $users[1]->collection()
        );

        $users = new \ArrayIterator([
            new User(),
            new User()
        ]);

        $users = (new Cursor($users))->connect(new Users(new Connection('mongodb://xxx', 'xxx')))->toArray();

        $this->assertNotNull(
            $users[0]->collection()
        );

        $this->assertNotNull(
            $users[1]->collection()
        );
    }
}
