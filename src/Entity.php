<?php

namespace Abellion\ODM\MongoDB;

use ArrayObject;
use JsonSerializable;

use MongoDB\BSON\ObjectId;
use MongoDB\BSON\Serializable;
use MongoDB\BSON\Unserializable;

class Entity extends ArrayObject implements JsonSerializable, Serializable, Unserializable
{
	public function __construct(array $data = [])
	{
		foreach ($data as $name => $value) {
			$this->offsetSet($name, $value);
		}

		parent::__construct((array) $this, ArrayObject::ARRAY_AS_PROPS);
	}

	public function get($name)
	{
		return parent::offsetGet($name);
	}

	public function set($name, $value)
	{
		parent::offsetSet($name, $value);
	}

	public function offsetGet($name)
	{
		$getter = self::camelize($name);
		$getter = "get" . ucfirst($getter);

		if (method_exists($this, $getter)) {
			return call_user_func([$this, $getter]);
		}

		return $this->get($name);
	}

	public function offsetSet($name, $value)
	{
		$setter = self::camelize($name);
		$setter = "set" . ucfirst($setter);

		if (method_exists($this, $setter)) {
			return 	call_user_func([$this, $setter], $value);
		}

		return $this->set($name, $value);
	}

	public function jsonSerialize(array $data = null)
	{
		$data = ($data === null) ? $this->getArrayCopy() : $data;

		foreach ($data as $key => $value) {
			if ($value instanceof ObjectId) {
				$data[$key] = (string) $value;
			} else if ($value instanceof self || is_array($value)) {
				$data[$key] = $this->jsonSerialize((array) $value);
			}
		}

		return $data;
	}

	public function toArray()
	{
		return $this->jsonSerialize();
	}

	public function bsonSerialize()
	{
        return (object) $this->getArrayCopy();
	}

	public function bsonUnserialize(array $data)
	{
		$this->__construct($data);
	}

    public static function camelize($word)
    {
        return lcfirst(self::classify($word));
    }

    public static function classify($word)
    {
        return str_replace(" ", "", ucwords(strtr($word, "_-", "  ")));
    }

}
