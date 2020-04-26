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
     * The MongoDB database
     * @var null|Database
     */
    private $database = null;

    /**
     * Construct a new connection
     *
     * @param string $host
     * @param string $database
     * @param array  $options
     */
    public function __construct(string $host, string $database, array $options = [])
    {
        $this->connection['options'] = $options;
        $this->connection['host'] = $host;
        $this->connection['database'] = $database;
    }

    /**
     * Return the connection's options
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

        return $this->manager = new Manager($this->connection['host'], $this->connection['options']['server'] ?? [], $this->connection['options']['driver'] ?? []);
    }

    /**
     * Return a database instance
     *
     * @return Database
     */
    public function getDatabase()
    {
        if ($this->database) {
            return $this->database;
        }

        return $this->database = new Database($this->getManager(), $this->getDatabaseName());
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

        return $this->client = new Client($this->connection['host'], $this->connection['options']['server'] ?? [], $this->connection['options']['driver'] ?? []);
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
