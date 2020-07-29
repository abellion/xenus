<?php

namespace Xenus\Concerns;

trait HasConvenientWrites
{
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
}
