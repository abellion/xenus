<?php

namespace Xenus\Document;

trait MongoAccess
{
    /**
     * Serializes the document to a MongoDB readable value
     *
     * @return array The document as array
     */
    public function bsonSerialize()
    {
        return $this->document;
    }

    /**
     * Unserializes a document comming from MongoDB
     *
     * @param  array  $document The document as array
     */
    public function bsonUnserialize(array $document)
    {
        self::fillFromSetter($document);
    }
}
