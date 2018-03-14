<?php

namespace Xenus;

use MongoDB\Database;
use MongoDB\BSON\ObjectID;

class Collection extends \MongoDB\Collection
{
    const NAME = null;
    const DOCUMENT = Document::class;

    public function __construct(Database $database, array $options = [])
    {
        if (null === ($name = $options['name'] ?? static::NAME)) {
            throw new Exceptions\InvalidArgumentException('The "name" argument is required');
        }

        if (null === ($document = $options['document'] ?? static::DOCUMENT)) {
            throw new Exceptions\InvalidArgumentException('The "document" argument is required');
        }

        parent::__construct($database->getManager(), $database->getDatabaseName(), $name, array_merge($options, [
            'typeMap' => ['root' => $document, 'array' => 'array', 'document' => 'array']
        ]));
    }

    /**
     * Resolve the given collection
     *
     * @param  string $collection
     *
     * @return Collection
     */
    public function resolve(string $collection)
    {
        if (false === class_exists($collection)) {
            throw new Exceptions\InvalidArgumentException(sprintf('Target collection "%s" does not exist', $collection));
        }

        return new $collection(new Database($this->getManager(), $this->getDatabaseName()));
    }

    /**
     * Insert the document
     *
     * @param  array|object $document
     * @param  array        $options
     *
     * @return MongoDB\InsertOneResult
     */
    public function insert($document, array $options = [])
    {
        return parent::insertOne($document, $options);
    }

    /**
     * Delete the document
     *
     * @param  array|object $document
     * @param  array        $options
     *
     * @return MongoDB\DeleteResult
     */
    public function delete($document, array $options = [])
    {
        return parent::deleteOne(['_id' => $document['_id']], $options);
    }

    /**
     * Update the document
     *
     * @param  array|object $document
     * @param  array        $options
     *
     * @return MongoDB\UpdateResult
     */
    public function update($document, array $options = [])
    {
        return parent::updateOne(['_id' => $document['_id']], ['$set' => $document], $options);
    }

    /**
     * Find documents matching some filters
     *
     * @param  array            $filter
     * @param  array            $options
     *
     * @return Xenus\Cursor
     */
    public function find($filter = [], array $options = [])
    {
        return (new Cursor(parent::find($filter, $options)))->connect($this);
    }

    /**
     * Find one document matching an ID or some filters
     *
     * @param  array|ObjectID   $filter
     * @param  array            $options
     *
     * @return array|object|null
     */
    public function findOne($filter = [], array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        $document = parent::findOne($filter, $options);

        if ($document instanceof Document) {
            $document->connect($this);
        }

        return $document;
    }

    /**
     * Find one document matching an ID or some filters and delete it
     *
     * @param  array|ObjectID   $filter
     * @param  array            $options
     *
     * @return array|object|null
     */
    public function findOneAndDelete($filter = [], array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        $document = parent::findOneAndDelete($filter, $options);

        if ($document instanceof Document) {
            $document->connect($this);
        }

        return $document;
    }

    /**
     * Find one document matching an ID or some filters and update it
     *
     * @param  array|ObjectID   $filter
     * @param  array|object     $update
     * @param  array            $options
     *
     * @return [type]          [description]
     */
    public function findOneAndUpdate($filter, $update, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        $document = parent::findOneAndUpdate($filter, $update, $options);

        if ($document instanceof Document) {
            $document->connect($this);
        }

        return $document;
    }

    /**
     * Find one document matching an ID or some filters and replace it
     *
     * @param  array|ObjectID   $filter
     * @param  array|object     $replacement
     * @param  array            $options
     *
     * @return array|object|null
     */
    public function findOneAndReplace($filter, $replacement, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        $document = parent::findOneAndReplace($filter, $replacement, $options);

        if ($document instanceof Document) {
            $document->connect($this);
        }

        return $document;
    }

    /**
     * Delete one document matching an ID or some filters
     *
     * @param  array|ObjectID   $filter
     * @param  array            $options
     *
     * @return MongoDB\DeleteResult
     */
    public function deleteOne($filter, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::deleteOne($filter, $options);
    }

    /**
     * Update one document matching an ID or some filters
     *
     * @param  array|ObjectID   $filter
     * @param  array|object     $update
     * @param  array            $options
     *
     * @return MongoDB\UpdateResult
     */
    public function updateOne($filter, $update, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::updateOne($filter, $update, $options);
    }

    /**
     * Replace one document matching an ID or some filters
     *
     * @param  array|ObjectID   $filter
     * @param  array|object     $replacement
     * @param  array            $options
     *
     * @return MongoDB\UpdateResult
     */
    public function replaceOne($filter, $replacement, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::replaceOne($filter, $replacement, $options);
    }
}
