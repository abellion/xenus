<?php

namespace Xenus;

class CollectionConfiguration
{
    /**
     * The collection's properties
     * @var array
     */
    private $properties = null;

    /**
     * The collection's connection
     * @var Connection
     */
    private $connection = null;

    public function __construct(Connection $connection, array $properties = [])
    {
        $this->connection = $connection;
        $this->properties = $properties;
    }

    /**
     * Get the collection's connection
     *
     * @return Connection
     */
    public function getCollectionConnection()
    {
        return $this->connection;
    }

    /**
     * Determine if the given proeprty exists
     *
     * @param  string $property
     *
     * @return bool
     */
    public function has(string $property) {
        if (isset($this->properties[$property])) {
            return true;
        }

        return false;
    }

    /**
     * Get the collection's options
     *
     * @return array
     */
    public function getCollectionOptions()
    {
        return ($this->properties['options'] ?? []) + [
            'typeMap' => ['root' => $this->properties['document'] ?? Document::class, 'array' => 'array', 'document' => 'array']
        ];
    }

    /**
     * Get the collection's name
     *
     * @return string|null
     */
    public function getCollectionName()
    {
        return $this->properties['name'] ?? null;
    }
}
