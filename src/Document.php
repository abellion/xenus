<?php

namespace Xenus;

use Iterator;
use ArrayAccess;
use JsonSerializable;
use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

class Document implements Iterator, ArrayAccess, JsonSerializable, Serializable, Unserializable
{
    use Document\MongoAccess;
    use Document\ArrayAccess;
    use Document\ArrayIterator;
    use Document\Mutators\EmbedMutator;
    use Document\Accessors\CamelCaseAccessor;
    use Document\Serializers\JsonSerializer;

    protected $withId = false;
    protected $document = [];

    /**
     * Returns the document's values for debugging
     *
     * @return array The document's values
     */
    public function __debugInfo()
    {
        return $this->document;
    }

    /**
     * @param array $document The values to put in the document
     */
    public function __construct($document = [])
    {
        if ($this->withId && !isset($document['_id'])) {
            self::setFromSetter('_id', new ObjectID());
        }

        self::fillFromSetter(($document instanceof self) ? $document->document : $document);
    }

    /**
     * Gets the value for the given key
     *
     * @param  string $offset The key
     *
     * @return mixed The value
     */
    public function get(string $offset)
    {
        return $this->document[$offset];
    }

    /**
     * Gets whether the given key exists or not
     *
     * @param  string  $offset The key
     *
     * @return boolean Whether the given key exists or not
     */
    public function has(string $offset)
    {
        return isset($this->document[$offset]);
    }

    /**
     * Fills the document whith the given values
     *
     * @param  array  $document The values
     *
     * @return self
     */
    public function merge(array $document)
    {
        return self::fillFromSetter($document);
    }

    /**
     * Returns the document as an array
     *
     * @return array The document as an array
     */
    public function toArray()
    {
        return $this->document;
    }

    /**
     * Gets a value from a getter if it exists, or fallback on the internal array
     *
     * @param  string $offset The key
     *
     * @return mixed The value
     */
    public function getFromGetter(string $offset)
    {
        $getter = $this->getterIze($offset);

        if (method_exists($this, $getter)) {
            return call_user_func([$this, $getter]);
        }

        return self::get($offset);
    }

    /**
     * Sets the value on the offset
     *
     * @param string $offset The key to retrieve the value
     * @param mixed $value  The value
     */
    public function set(string $offset, $value)
    {
        $this->document[$offset] = $value;

        return $this;
    }

    /**
     * Sets the value through a setter
     *
     * @param string $offset The key to retrieve the value
     * @param mixed $value  The value
     */
    public function setFromSetter(string $offset, $value)
    {
        $setter = $this->setterIze($offset);

        if (method_exists($this, $setter)) {
            return call_user_func([$this, $setter], $value);
        }

        return self::set($offset, $value);
    }

    /**
     * Fills the document with the given array
     *
     * @param  array  $document The array
     *
     * @return self
     */
    public function fill(array $document)
    {
        foreach ($document as $offset => $value) {
            self::set($offset, $value);
        }

        return $this;
    }

    /**
     * Fills the document, though the setters, with the given array
     *
     * @param  array  $document The array
     *
     * @return self
     */
    public function fillFromSetter(array $document)
    {
        foreach ($document as $offset => $value) {
            self::setFromSetter($offset, $value);
        }

        return $this;
    }
}
