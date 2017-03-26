<?php

namespace Xenus\Collection;

use Xenus\Document;
use MongoDB\BSON\ObjectID;

trait CRUDMethods
{
    public function select(ObjectID $id, array $options = [])
    {
        return $this->collection->findOne([
            '_id' => $id
        ], $options);
    }

    public function delete(ObjectID $id, array $options = [])
    {
        return $this->collection->deleteOne([
            '_id' => $id
        ], $options);
    }

    public function insert($document, array $options = [])
    {
        return $this->collection->insertOne($document, $options);
    }

    public function update($document, array $options = [])
    {
        return $this->collection->updateOne([
            '_id' => $document['_id']
        ], [
            '$set' => $document
        ], $options);
    }
}
