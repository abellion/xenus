<?php

namespace Xenus\Document;

trait ArrayAccess
{
    /**
     * Return from a getter the value at the given offset
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
     * Return the value at the given offset
     *
     * @param  string $offset The key

     * @return mixed The value
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->document[$offset];
    }

    /**
     * Set from a setter the given value at the given offset
     *
     * @param string $offset The key
     * @param mixed $value  The value
     */
    public function __set(string $offset, $value)
    {
        self::setFromSetter($offset, $value);
    }

    /**
     * Set the given value at the given offset
     *
     * @param  string $offset The key
     * @param  mixed $value  The value
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->document[$offset] = $value;
    }

    /**
     * Unset the document's value at the given offset
     *
     * @param  string $offset The key
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->document[$offset]);
    }

    /**
     * Determine whether the given key exists or not in the document
     *
     * @param  string $offset The key
     *
     * @return bool Whether the given key exists or not in the document
     */
    public function offsetExists($offset): bool
    {
        return isset($this->document[$offset]);
    }
}
