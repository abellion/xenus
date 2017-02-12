<?php

namespace Abellion\ODM\Document;

trait ArrayIterator
{
	public function rewind()
    {
        reset($this->document);
    }

    public function current()
    {
		return current($this->document);
    }

    public function key()
    {
		return key($this->document);
    }

    public function next()
    {
		return next($this->document);
    }

    public function valid()
    {
        $key = key($this->document);

        return ($key !== NULL && $key !== FALSE);
    }
}
