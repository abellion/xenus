<?php

namespace Xenus\Document;

trait ArrayAccess
{
    public function __get(string $offset)
    {
        return self::getFromGetter($offset);
    }

    public function offsetGet($offset)
    {
        return $this->document[$offset];
    }

    public function __set(string $offset, $value)
    {
        self::setFromSetter($offset, $value);
    }

    public function offsetSet($offset, $value)
    {
        $this->document[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->document[$offset]);
    }

    public function offsetExists($offset)
    {
        return isset($this->document[$offset]);
    }
}
