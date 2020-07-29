<?php

namespace Xenus\Tests\Mocks;

use Xenus\EventDispatcher;

class EventDispatcherMock implements EventDispatcher
{
    public $dispatched = [];

    /**
     * Dispatch the given event
     *
     * @param  object $event
     *
     * @return void
     */
    public function dispatch($event)
    {
        $this->dispatched[] = get_class($event);
    }
}
