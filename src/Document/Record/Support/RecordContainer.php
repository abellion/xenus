<?php

namespace Xenus\Document\Record\Support;

trait RecordContainer
{
    /**
     * Hold the record's fields
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Construct a new record
     *
     * @param array $fields
     */
    public function __construct(array $fields = [])
    {
        $this->fields = $fields;
    }

    /**
     * Return the record's fields for debugging purposes
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->fields;
    }

    /**
     * Return the list of properties that should be kept when calling "serialize" on the object
     *
     * @return array
     */
    public function __sleep(): array
    {
        return ['fields'];
    }

    /**
     * Return the fields
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->fields;
    }

    /**
     * Return the fiels in a JSON serializable format
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Return the value of the current field
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->fields);
    }

    /**
     * Return the key of the current field
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->fields);
    }

    /**
     * Advance the internal pointer of the fields
     *
     * @return void
     */
    public function next(): void
    {
        next($this->fields);
    }

    /**
     * Reset the internal pointer of the fields
     *
     * @return void
     */
    public function rewind(): void
    {
        reset($this->fields);
    }

    /**
     * Check if the current fields position is valid
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return key($this->fields) !== null;
    }

    /**
     * Determine if the given offset exists
     *
     * @param  mixed $offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->fields);
    }

    /**
     * Get the value for a given offset
     *
     * @param  mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->fields[$offset];
    }

    /**
     * Set the value at the given offset
     *
     * @param  mixed $offset
     * @param  mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->fields[$offset] = $value;
    }

    /**
     * Unset the value at the given offset
     *
     * @param  mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->fields[$offset]);
    }
}
