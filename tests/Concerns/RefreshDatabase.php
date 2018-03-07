<?php

namespace Xenus\Tests\Concerns;

use MongoDB\Client;

trait RefreshDatabase
{
    private $database;

    protected function setUp()
    {
        $this->createDatabase();
    }

    protected function tearDown()
    {
        $this->deleteDatabase();
    }

    protected function deleteDatabase()
    {
        $this->database->drop();
    }

    protected function createDatabase()
    {
        $this->database = (new Client(getenv('MONGODB_URI')))->selectDatabase(getenv('MONGODB_DATABASE'));
    }
}
