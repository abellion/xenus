<?php

namespace Xenus\Document;

trait ArrayIterator
{
    /**
     * Rewind the document
     */
    public function rewind(): void
    {
        reset($this->document);
    }

    /**
     * Return the current element
     *
     * @return mixed The current element
     */
    public function current(): mixed
    {
        return current($this->document);
    }

    /**
     * Return the current key
     *
     * @return string The current key
     */
    public function key(): string
    {
        return key($this->document);
    }

    /**
     * Move the array cursor forward and return the next element
     *
     * @return mixed The next element
     */
    #[\ReturnTypeWillChange]
    public function next(): mixed
    {
        return next($this->document);
    }

    /**
     * Determine whether or not the array is ready for an iteration
     *
     * @return bool Whether or not the array is ready for an iteration
     */
    public function valid(): bool
    {
        $key = key($this->document);

        return ($key !== null && $key !== false);
    }
}
