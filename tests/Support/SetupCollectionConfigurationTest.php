<?php

namespace Xenus\Tests\Support;

use Xenus\Connection;

trait SetupCollectionConfigurationTest
{
    use SetupTestsHooks;

    private $setup = [
        'createFakeConnection'
    ];

    private $connection;

    /**
     * Create a fake connection
     *
     * @return void
     */
    private function createFakeConnection()
    {
        $this->connection = new Connection('mongodb://xxx', 'xxx');
    }
}
