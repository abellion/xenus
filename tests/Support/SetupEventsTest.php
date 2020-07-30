<?php

namespace Xenus\Tests\Support;

use Xenus\Tests\Tests\Stubs\TokensCollection as Tokens;
use Xenus\Tests\Mocks\EventDispatcherMock as EventDispatcher;

trait SetupEventsTest
{
    use RefreshDatabase;

    private $tokens;

    private $dispatcher;

    public function setUp()
    {
        $this->createDatabase();

        $this->tokens = (new Tokens($this->connection))->setEventDispatcher(
            $this->dispatcher = new EventDispatcher()
        );
    }
}
