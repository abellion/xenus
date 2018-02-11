<?php

namespace Xenus;

use MongoDB\Database;
use MongoDB\BSON\ObjectID;
use MongoDB\Collection as BaseCollection;

abstract class Collection extends BaseCollection
{
    protected $name;
    protected $document = Document::class;

    public function __construct(Database $database)
    {
        parent::__construct($database->getManager(), $database->getDatabaseName(), $this->name, [
            'typeMap' => ['root' => $this->document, 'array' => 'array', 'document' => 'array']
        ]);
    }

    /**
     * Insert the document
     *
     * @param  array|object $document
     * @param  array        $options
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
     * @return Xenus\Cursor
     */
    public function find($filter = [], array $options = [])
    {
        return new Cursor(parent::find($filter, $options));
    }

    /**
     * Find one document matching an ID or some filters
     *
     * @param  array|ObjectID   $filter
     * @param  array            $options
     * @return array|object|null
     */
    public function findOne($filter = [], array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        $cursor = $this->find($filter, array_merge($options, ['limit' => 1]));
        $result = current($cursor->toArray());

        return ($result === false) ? null : $result;
    }

    /**
     * Delete one document matching an ID or some filters
     *
     * @param  array|ObjectID   $filter
     * @param  array            $options
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
     * @param  array|object     $replace
     * @param  array            $options
     * @return MongoDB\UpdateResult
     */
    public function replaceOne($filter, $replace, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::replaceOne($filter, $replace, $options);
    }
}
