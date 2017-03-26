<?php

namespace Xenus\Document\Serializers;

use Traversable;
use MongoDB\BSON\ObjectID;

trait HttpSerializer
{
    public function toHttp()
    {
        return $this->httpSerialize();
    }

    public function httpSerialize()
    {
        return self::httpSerializeIterator($this->document);
    }

    private static function httpSerializeIterator($data)
    {
        $document = [];

        foreach ($data as $offset => $value) {
            if ($value instanceof ObjectID) {
                $document[$offset] = (string) $value;
            } elseif (is_array($value) || $value instanceof Traversable) {
                $document[$offset] = self::httpSerializeIterator($value);
            } else {
                $document[$offset] = $value;
            }
        }

        return $document;
    }
}
