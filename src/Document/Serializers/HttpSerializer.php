<?php

namespace Abellion\ODM\Document\Serializers;

use Traversable;
use MongoDB\BSON\ObjectID;

trait HttpSerializer
{
	public function httpSerialize()
	{
		return self::httpSerializeIterator($this->document);
	}

	private static function httpSerializeIterator(array $data)
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
