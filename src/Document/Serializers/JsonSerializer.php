<?php

namespace Abellion\Xenus\Document\Serializers;

trait JsonSerializer
{
	public function toJson()
	{
		return $this->jsonSerialize();
	}

	public function jsonSerialize()
	{
		return $this->defaultSerialize();
	}
}
