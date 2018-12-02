<?php

namespace Xenus;

use MongoDB\Client;
use MongoDB\Database;
use MongoDB\Driver\Manager;

class Connection
{
    /**
     * The connection configuration
     * @var array
     */
    private $connection = [];

    /**
     * The MongoDB client
     * @var null|Client
     */
    private $client = null;

    /**
     * The MongoDB manager
     * @var null|Manager
     */
    private $manager = null;

    /**
     * Construct a new connection
     *
     * @param string $host
     * @param string $database
     * @param array  $options
     */
    public function __construct(string $host, string $database, array $options = ['server' => [], 'driver' => []])
    {
        $this->connection = ['host' => $host, 'database' => $database, 'options' => $options];
    }

    /**
     * Return a manager instance
     *
     * @return Manager
     */
    public function getManager()
    {
        if ($this->manager) {
            return $this->manager;
        }

        return $this->manager = new Manager($this->connection['host'], $this->connection['options']['server'], $this->connection['options']['driver']);
    }

    /**
     * Return a new database instance
     *
     * @param  array  $options
     *
     * @return Database
     */
    public function getDatabase(array $options = [])
    {
        return new Database($this->getManager(), $this->connection['database'], $options);
    }

    /**
     * Return a client instance
     *
     * @return Client
     */
    public function getClient()
    {
        if ($this->client) {
            return $this->client;
        }

        return $this->client = new Client($this->connection['host'], $this->connection['options']['server'], $this->connection['options']['driver']);
    }
}
