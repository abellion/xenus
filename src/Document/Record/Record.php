<?php

namespace Xenus\Document\Record;

use Iterator;
use ArrayAccess;
use JsonSerializable;

class Record implements Iterator, ArrayAccess, JsonSerializable
{
    use Support\RecordContainer;

    /**
     * Determine if the given field is part of the record
     * @param  string  $field
     * @return boolean
     */
    public function has(string $field): bool
    {
        return $this->offsetExists($field);
    }

    /**
     * Get a field from the record
     * @param  string $field
     * @param  mixed $default
     * @return mixed
     */
    public function get(string $field, $default = null)
    {
        if ($this->offsetExists($field)) {
            return $this->offsetGet($field);
        }

        return $default;
    }

    /**
     * Set a field to the record
     * @param  string $field
     * @param  mixed $value
     * @return self
     */
    public function set(string $field, $value): self
    {
        $this->offsetSet($field, $value);

        return $this;
    }
}
