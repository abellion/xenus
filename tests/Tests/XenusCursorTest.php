<?php

namespace Xenus\Tests\Tests;

use Xenus\Cursor;

use Xenus\Tests\Tests\Stubs\UserDocument as User;
use Xenus\Tests\Tests\Stubs\UsersCollection as Users;

use Xenus\Tests\Support\RefreshDatabase;

class XenusCursorTest extends \PHPUnit\Framework\TestCase
{
    use RefreshDatabase;

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

        $users = (new Cursor($users))->connect(new Users($this->database))->toArray();

        $this->assertNotNull(
            $users[0]->collection()
        );

        $this->assertNotNull(
            $users[1]->collection()
        );
    }
}
