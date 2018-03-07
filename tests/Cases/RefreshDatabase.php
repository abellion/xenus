<?php

namespace Xenus\Tests\Cases;

use MongoDB\Client;

trait RefreshDatabase
{
    private $client;
    private $database;

    public function setUp()
    {
        $this->client = new Client(getenv('MONGODB_URI'));
        $this->database = $this->client->{getenv('MONGODB_DATABASE')};
    }

    public function tearDown()
    {
        $this->database->drop();
    }
}
