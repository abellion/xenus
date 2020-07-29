<?php

namespace Xenus;

interface EventDispatcher
{
    /**
     * Dispatch the given event
     * @param  object $event
     * @return void
     */
    public function dispatch($event);
}
