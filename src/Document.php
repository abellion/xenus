<?php

namespace Abellion\Xenus;

use Iterator;
use ArrayAccess;
use JsonSerializable;
use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

class Document implements Iterator, ArrayAccess, JsonSerializable, Serializable, Unserializable
{
	use Document\MongoAccess;
	use Document\ArrayAccess;
	use Document\ArrayIterator;
	use Document\Mutators\CamelCaseMutator;
	use Document\Decorators\EmbedDecorator;
	use Document\Serializers\JsonSerializer;
	use Document\Serializers\HttpSerializer;
	use Document\Serializers\DefaultSerializer;

	protected $withId = false;
	protected $document = [];

	public function __debugInfo()
	{
		return $this->document;
	}

	public function __construct(array $document = [])
	{
		if ($this->withId && !isset($document['_id'])) {
			self::setFromSetter('_id', new ObjectID());
		}

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
