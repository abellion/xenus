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
     * Set from a setter the given value at the given offset
     *
     * @param string $offset The key
     * @param mixed $value  The value
     */
    public function __set(string $offset, $value)
    {
        self::setFromSetter($offset, $value);
    }
}
