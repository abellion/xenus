<?php

namespace Xenus\Document\Serializers;

trait JsonSerializer
{
    /**
     * Gets a JSON serializable format
     *
     * @return array The JSON serializable format
     */
    public function toJson()
    {
        return $this->jsonSerialize();
    }

    /**
     * Gets a JSON serializable format
     *
     * @return array The JSON serializable format
     */
    public function jsonSerialize()
    {
        return $this->document;
    }
}
