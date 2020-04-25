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
    public function __construct(string $host, string $database, array $options = null)
    {
        $this->connection = [
            'options' => ['server' => $options['server'] ?? [], 'driver' => $options['driver'] ?? []],
            'host' => $host,
            'database' => $database
        ];
    }

    /**
     * Return the connection options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->connection['options'];
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

    /**
     * Return the database name
     *
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->connection['database'];
    }
}
