<?php

namespace Xenus\Document;

trait ArrayIterator
{
    /**
     * Rewinds the document
     */
    public function rewind()
    {
        reset($this->document);
    }

    /**
     * Returns the current element
     *
     * @return mixed The current element
     */
    public function current()
    {
        return current($this->document);
    }

    /**
     * Returns the current key
     *
     * @return string The current key
     */
    public function key()
    {
        return key($this->document);
    }

    /**
     * Moves the array cursor forward and returns the next element
     *
     * @return mixed The next element
     */
    public function next()
    {
        return next($this->document);
    }

    /**
     * Determines whether or not the array is ready for an iteration
     *
     * @return bool Whether or not the array is ready for an iteration
     */
    public function valid()
    {
        $key = key($this->document);

        return ($key !== null && $key !== false);
    }
}
