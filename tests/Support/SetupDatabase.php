<?php

namespace Xenus\Tests\Support;

use Xenus\Connection;

trait SetupDatabase
{
    private $connection;

    /**
     * Delete the database
     *
     * @return void
     */
    private function deleteDatabase()
    {
        $this->connection->getDatabase()->drop();
    }

    /**
     * Create the database
     *
     * @return void
     */
    private function createDatabase()
    {
        $this->connection = new Connection(getenv('MONGODB_URI'), getenv('MONGODB_DATABASE'));
    }
}
