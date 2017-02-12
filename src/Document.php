<?php

namespace Abellion\ODM;

use ArrayAccess;
use Iterator as ArrayIterator;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

class Document implements ArrayAccess, ArrayIterator, Serializable, Unserializable
{
	use Document\ArrayAccess;
	use Document\ArrayIterator;
	use Document\MongoAccess;

	private $document = [];

	public function __construct(array $document = [])
	{
		$this->fill($document);
	}

	public function get($offset)
	{
		return $this->document[$offset];
	}

	public function set($offset, $value)
	{
		$this->document[$offset] = $value;

		return $this;
	}

	public function getFromGetter($offset)
	{
		return $this->get($offset);
	}

	public function setFromSetter($offset, $value)
	{
		return $this->set($offset, $value);
	}

	public function fill(array $document)
	{
		foreach ($document as $offset => $value) {
			$this->set($offset, $value);
		}
	}

	public function fillFromSetter(array $document)
	{
		foreach ($document as $offset => $value) {
			$this->setFromSetter($offset, $value);
		}
	}
}
