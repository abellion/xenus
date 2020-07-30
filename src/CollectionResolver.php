<?php

namespace Xenus;

interface CollectionResolver
{
    /**
     * Resolve the given collection
     *
     * @param  string $collection
     *
     * @return Collection
     */
    public function resolve(string $collection);
}
