<?php

namespace Xenus\Collection;

use Xenus\Document;
use MongoDB\BSON\ObjectID;

trait CRUDMethods
{
    public function find(ObjectID $id, array $options = [])
    {
        return $this->collection->findOne(['_id' => $id], $options);
    }

    public function delete(Document $document, array $options = [])
    {
        return $this->collection->deleteOne(['_id' => $document->id], $options);
    }

    public function insert(Document $document, array $options = [])
    {
        return $this->collection->insertOne($document, $options);
    }

    public function update(Document $document, array $options = [])
    {
        return $this->collection->updateOne(['_id' => $document['_id']], ['$set' => $document], $options);
    }
}
