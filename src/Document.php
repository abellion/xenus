<?php

namespace Xenus;

use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

use Xenus\Document\Record\Record;

class Document extends Record implements Serializable, Unserializable
{
    use Concerns\HasCollection;
    use Concerns\HasId;
    use Concerns\HasRelationships;

    use Document\ArrayAccess;
    use Document\CamelCaseAccessor;

    protected $withId = false;

    /**
     * Return the document's values for debugging
     *
     * @return array
     */
    public function __debugInfo()
    {
        return $this->fields;
    }

    /**
     * @param array $document The values to put in the document
     */
    public function __construct($document = [])
    {
        if ($this->withId && !isset($document['_id'])) {
            self::setFromSetter('_id', new ObjectID());
        }

        self::fillFromSetter(($document instanceof self) ? $document->fields : $document);
    }

    /**
     * Return a new document only with the specified fields
     *
     * @param  array  $fields The keys to keep
     *
     * @return Xenus\Document
     */
    public function with(array $fields)
    {
        $document = new static();
        $document->fields = [];

        foreach ($fields as $field) {
            if (array_key_exists($field, $this->fields)) {
                $document->fields[$field] = $this->fields[$field];
            }
        }

        return $document;
    }

    /**
     * Return a new document without the specified fields
     *
     * @param  array  $fields The keys to drop
     *
     * @return Xenus\Document
     */
    public function without(array $fields)
    {
        $document = new static();
        $document->fields = [];

        foreach ($this->fields as $key => $value) {
            if (!in_array($key, $fields)) {
                $document->fields[$key] = $this->fields[$key];
            }
        }

        return $document;
    }

    /**
     * Fill the document whith the given values
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
     * Get a value from a getter if it exists, or fallback on the internal array
     *
     * @param  string $offset The key
     *
     * @return mixed
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
     * Set the given value through a setter
     *
     * @param string $offset The key to retrieve the value
     * @param mixed  $value  The value
     *
     * @return self
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
     * Fill the document with the given array
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
     * Fill the document, though the setters, with the given array
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

    /**
     * Serialize the document to a MongoDB readable value
     *
     * @return array The document as array
     */
    public function bsonSerialize()
    {
        return $this->fields;
    }

    /**
     * Unserialize a document comming from MongoDB
     *
     * @param  array  $document The document as array
     */
    public function bsonUnserialize(array $document)
    {
        self::fillFromSetter($document);
    }
}
