<?php

namespace Abellion\Xenus\Document\Serializers;

trait DefaultSerializer
{
	public function toArray()
	{
		return $this->defaultSerialize();
	}

	public function defaultSerialize()
	{
		return $this->document;
	}
}
