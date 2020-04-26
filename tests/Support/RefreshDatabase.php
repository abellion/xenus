<?php

namespace Xenus\Tests\Support;

use Xenus\Connection;

trait RefreshDatabase
{
    private $connection;

    protected function tearDown()
    {
        $this->deleteDatabase();
    }

    protected function deleteDatabase()
    {
        $this->connection->getDatabase()->drop();
    }

    protected function setUp()
    {
        $this->createDatabase();
    }

    protected function createDatabase()
    {
        $this->connection = new Connection(getenv('MONGODB_URI'), getenv('MONGODB_DATABASE'));
    }
}
