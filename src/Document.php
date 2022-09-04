<?php

namespace Xenus;

use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

use Xenus\Document\Record\Record;
use Xenus\Document\Support\DynamicProperties;

class Document extends Record implements Serializable, Unserializable
{
    use Concerns\HasCollection;
    use Concerns\HasId;
    use Concerns\HasRelationships;

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
        if ($this->withId && isset($this['_id']) !== true) {
            $this->setId(new ObjectID());
        }

        foreach ($document as $key => $value) {
            $this->{$key} = $value;
        }
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
        foreach ($document as $key => $value) {
            $this->{$key} = $value;
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
        return $this->toArray();
    }

    /**
     * Unserialize a document comming from MongoDB
     *
     * @param  array  $document The document as array
     */
    public function bsonUnserialize(array $document)
    {
        call_user_func([$this, '__construct'], $document);
    }

    /**
     * Fluently retrieve a property from the document
     *
     * @param  string $property
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        return call_user_func(DynamicProperties::findGetter($this, $property));
    }

    /**
     * Fluently set a property to the document
     *
     * @param string $property
     *
     * @param mixed
     */
    public function __set(string $property, $value)
    {
        return call_user_func(DynamicProperties::findSetter($this, $property), $value);
    }
}
