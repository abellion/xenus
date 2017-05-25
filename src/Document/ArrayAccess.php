<?php

namespace Xenus\Document;

trait ArrayAccess
{
    /**
     * Returns from a getter the value at the given offset
     *
     * @param  string $offset The key
     *
     * @return mixed The value
     */
    public function __get(string $offset)
    {
        return self::getFromGetter($offset);
    }

    /**
     * Returns the value at the given offset
     *
     * @param  string $offset The key

     * @return mixed The value
     */
    public function offsetGet($offset)
    {
        return $this->document[$offset];
    }

    /**
     * Sets from a setter the given value at the given offset
     *
     * @param string $offset The key
     * @param mixed $value  The value
     */
    public function __set(string $offset, $value)
    {
        self::setFromSetter($offset, $value);
    }

    /**
     * Sets the given value at the given offset
     *
     * @param  string $offset The key
     * @param  mixed $value  The value
     */
    public function offsetSet($offset, $value)
    {
        $this->document[$offset] = $value;
    }

    /**
     * Unsets the document's value
     *
     * @param  stirng $offset The key
     */
    public function offsetUnset($offset)
    {
        unset($this->document[$offset]);
    }

    /**
     * Determines whether the given key exists or not in the document
     *
     * @param  string $offset The key
     *
     * @return book Whether the given key exists or not in the document
     */
    public function offsetExists($offset)
    {
        return isset($this->document[$offset]);
    }
}
