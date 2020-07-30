<?php

namespace Xenus\Tests\Support;

use Xenus\Tests\Tests\Stubs\TokensCollection as Tokens;
use Xenus\Tests\Mocks\EventDispatcherMock as EventDispatcher;

trait SetupEventsTest
{
    use SetupDatabase, SetupTestsHooks;

    private $setup = [
        'createDatabase', 'createDispatcher', 'createTokensCollection'
    ];

    private $tearDown = [
        'deleteDatabase'
    ];

    private $dispatcher;

    private $tokens;

    /**
     * Create the event dispatcher
     *
     * @return void
     */
    private function createDispatcher()
    {
        $this->dispatcher = new EventDispatcher();
    }

    /**
     * Create the tokens collection
     *
     * @return void
     */
    private function createTokensCollection()
    {
        $this->tokens = (new Tokens($this->connection))->setEventDispatcher($this->dispatcher);
    }
}
