<?php

namespace Xenus\Concerns;

trait HasEvents
{
    /**
     * The events map
     * @var array
     */
    protected $events = [];

    /**
     * The dispatcher instance
     * @var EventDispatcher
     */
    protected $dispatcher;

    /**
     * Dispatch an event
     *
     * @param  string       $event
     * @param  array|object $document
     * @return void
     */
    protected function dispatch(string $event, $document)
    {
        if (isset($this->dispatcher) === false || isset($this->events[$event]) === false) {
            return ;
        }

        $this->dispatcher->dispatch(
            new $this->events[$event]($document);
        );
    }
}
