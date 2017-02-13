<?php

namespace Abellion\Xenus\Document\Serializers;

trait JsonSerializer
{
	public function jsonSerialize()
	{
		return $this->defaultSerialize();
	}
}
