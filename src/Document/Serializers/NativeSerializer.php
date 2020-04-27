<?php

namespace Xenus\Document\Serializers;

trait NativeSerializer
{
    /**
     * Specify which properties must be serialized
     *
     * @return array
     */
    public function __sleep()
    {
        return ['document'];
    }
}
