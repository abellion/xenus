<?php

namespace Abellion\Xenus\Document\Mutators;

trait CamelCaseMutator
{
	public function getterIze($offset)
	{
		return 'get' . str_replace(" ", "", ucwords(strtr($offset, "_-", "  ")));
	}

	public function setterIze($offset)
	{
		return 'set' . str_replace(" ", "", ucwords(strtr($offset, "_-", "  ")));
	}
}
