<?php

namespace Xenus\Document\Serializers;

trait JsonSerializer
{
    public function toJson()
    {
        return $this->jsonSerialize();
    }

    public function jsonSerialize()
    {
        return $this->document;
    }
}
