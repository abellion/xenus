<?php

namespace Xenus\Tests\Mocks;

use Xenus\CollectionResolver;
use Xenus\Connection;

class CollectionResolverMock implements CollectionResolver
{
    public $resolved = [];

    /**
     * Resolve the given collection
     *
     * @param  string $collection
     *
     * @return \Xenus\Collection
     */
    public function resolve(string $collection)
    {
        $this->resolved[] = $collection;

        return new $collection(
            new Connection('mongodb://xxx', 'xxx')
        );
    }
}
