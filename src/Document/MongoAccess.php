<?php

namespace Xenus\Document;

trait MongoAccess
{
    /**
     * Serialize the document to a MongoDB readable value
     *
     * @return array|object The document as array
     */
    #[\ReturnTypeWillChange]
    public function bsonSerialize()
    {
        return $this->document;
    }

    /**
     * Unserialize a document comming from MongoDB
     *
     * @param  array  $document The document as array
     */
    public function bsonUnserialize(array $document): void
    {
        self::fillFromSetter($document);
    }
}
