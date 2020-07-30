<?php

namespace Xenus\Tests\Stubs;

class TokensCollection extends \Xenus\Collection
{
    protected $name = 'tokens';
    protected $document = \Xenus\Document::class;

    /**
     * Set the event at the given hook
     *
     * @param  string $hook
     * @param  string $event
     *
     * @return self
     */
    public function setEvent(string $hook, string $event)
    {
        $this->events[$hook] = $event;

        return $this;
    }
}

