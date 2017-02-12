<?php

namespace Abellion\ODM\Document\Serializers;

trait JsonSerializer
{
	public function jsonSerialize()
	{
		return $this->defaultSerialize();
	}
}
