<?php

namespace Xenus\Tests\Mocks;

use Xenus\Connection;
use Xenus\CollectionResolver;

class CollectionResolverMock implements CollectionResolver
{
    public $resolved = [];

    /**
     * Resolve the given collection
     *
     * @param  string $collection
     *
     * @return Collection
     */
    public function resolve(string $collection)
    {
        $this->resolved[] = $collection;

        return new $collection(
            new Connection('mongodb://xxx', 'xxx')
        );
    }
}
