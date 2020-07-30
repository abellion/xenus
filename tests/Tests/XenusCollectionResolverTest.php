<?php

namespace Xenus\Tests\Tests;

use Xenus\Tests\Stubs\UsersCollection;
use Xenus\Tests\Stubs\CitiesCollection;
use Xenus\Tests\Mocks\CollectionResolverMock;

use Xenus\Connection;

class XenusCollectionResolverTest extends \PHPUnit\Framework\TestCase
{
    public function test_custom_resolver_is_used()
    {
        $cities = (new CitiesCollection(new Connection('mongodb://xxx', 'xxx')))->setCollectionResolver(
            $resolver = new CollectionResolverMock()
        );

        $cities->resolve(UsersCollection::class);

        $this->assertContains(
            UsersCollection::class, $resolver->resolved
        );
    }
}
