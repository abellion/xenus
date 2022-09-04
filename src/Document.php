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

    use Document\HasHelpers;

    protected $withId = false;

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
