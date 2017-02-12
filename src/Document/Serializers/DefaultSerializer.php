<?php

namespace Abellion\ODM\Document\Serializers;

trait DefaultSerializer
{
	public function defaultSerialize()
	{
		return $this->document;
	}
}
