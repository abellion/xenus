<?php

namespace Xenus\Document\Serializers;

trait JsonSerializer
{
    /**
     * Get a JSON serializable format
     *
     * @return array The JSON serializable format
     */
    public function toJson()
    {
        return $this->jsonSerialize();
    }

    /**
     * Get a JSON serializable format
     *
     * @return array The JSON serializable format
     */
    public function jsonSerialize(): array
    {
        return $this->document;
    }
}
