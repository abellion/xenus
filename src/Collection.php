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
     * @param  Document $document
     * @param  array    $options
     * @return MongoDB\InsertOneResult
     */
    public function insert(Document $document, array $options = [])
    {
        return parent::insertOne($document, $options);
    }

    /**
     * Delete the document
     *
     * @param  Document $document
     * @param  array    $options
     * @return MongoDB\DeleteResult
     */
    public function delete(Document $document, array $options = [])
    {
        return parent::deleteOne(['_id' => $document->id], $options);
    }

    /**
     * Update the document
     *
     * @param  Document $document
     * @param  array    $options
     * @return MongoDB\UpdateResult
     */
    public function update(Document $document, array $options = [])
    {
        return parent::updateOne(['_id' => $document['_id']], ['$set' => $document], $options);
    }

    /**
     * Find one document matching an ID or some filters
     *
     * @param  array|ObjectID  $filter
     * @param  array  $options
     * @return array|object|null
     */
    public function findOne($filter = [], array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::findOne($filter, $options);
    }

    /**
     * Delete one document matching an ID or some filters
     *
     * @param  array|ObjectID $filter
     * @param  array  $options
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
     * @param  array|ObjectID $filter
     * @param  array|object $update
     * @param  array  $options
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
     * @param  array|ObjectID $filter
     * @param  array|object $replace
     * @param  array  $options
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
