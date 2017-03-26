<?php

namespace Xenus\Document;

trait MongoAccess
{
    public function bsonSerialize()
    {
        return $this->document;
    }

    public function bsonUnserialize(array $document)
    {
        self::fillFromSetter($document);
    }
}
