<?php

namespace Xenus\Document;

trait ArrayIterator
{
    /**
     * Rewind the document
     */
    public function rewind()
    {
        reset($this->document);
    }

    /**
     * Return the current element
     *
     * @return mixed The current element
     */
    public function current()
    {
        return current($this->document);
    }

    /**
     * Return the current key
     *
     * @return string The current key
     */
    public function key()
    {
        return key($this->document);
    }

    /**
     * Move the array cursor forward and return the next element
     *
     * @return mixed The next element
     */
    public function next()
    {
        return next($this->document);
    }

    /**
     * Determine whether or not the array is ready for an iteration
     *
     * @return bool Whether or not the array is ready for an iteration
     */
    public function valid()
    {
        $key = key($this->document);

        return ($key !== null && $key !== false);
    }
}
