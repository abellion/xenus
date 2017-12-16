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

    public function insert(Document $document, array $options = [])
    {
        return parent::insertOne($document, $options);
    }

    public function delete(Document $document, array $options = [])
    {
        return parent::deleteOne(['_id' => $document->id], $options);
    }

    public function update(Document $document, array $options = [])
    {
        return parent::updateOne(['_id' => $document['_id']], ['$set' => $document], $options);
    }

    public function findOne($filter = [], array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::findOne($filter, $options);
    }

    public function deleteOne($filter, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::deleteOne($filter, $options);
    }

    public function updateOne($filter, $update, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::updateOne($filter, $update, $options);
    }

    public function replaceOne($filter, $replace, array $options = [])
    {
        if ($filter instanceof ObjectID) {
            $filter = ['_id' => $filter];
        }

        return parent::replaceOne($filter, $replace, $options);
    }
}
