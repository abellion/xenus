<?php

namespace Abellion\ODM;

use ArrayAccess;
use Iterator as ArrayIterator;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

class Document implements ArrayAccess, ArrayIterator, Serializable, Unserializable
{
	use Document\MongoAccess;
	use Document\ArrayAccess;
	use Document\ArrayIterator;
	use Document\Mutators\CamelCaseMutator;

	private $document = [];

	public function __construct(array $document = [])
	{
		self::fillFromSetter($document);
	}

	public function get($offset)
	{
		return $this->document[$offset];
	}

	public function getFromGetter($offset)
	{
		$getter = $this->getterIze($offset);

		if (method_exists($this, $getter)) {
			return call_user_func([$this, $getter]);
		}

		return self::get($offset);
	}

	public function set($offset, $value)
	{
		$this->document[$offset] = $value;

		return $this;
	}

	public function setFromSetter($offset, $value)
	{
		$setter = $this->setterIze($offset);

		if (method_exists($this, $setter)) {
			return call_user_func([$this, $setter], $value);
		}

		return self::set($offset, $value);
	}

	public function fill(array $document)
	{
		foreach ($document as $offset => $value) {
			self::set($offset, $value);
		}
	}

	public function fillFromSetter(array $document)
	{
		foreach ($document as $offset => $value) {
			self::setFromSetter($offset, $value);
		}
	}
}
