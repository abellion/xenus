<?php

namespace Abellion\Xenus\Document\Serializers;

trait DefaultSerializer
{
	public function defaultSerialize()
	{
		return $this->document;
	}
}
