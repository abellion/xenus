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
     * @return \MongoDB\InsertOneResult
     */
    public function insert($document, array $options = [])
    {
        $this->dispatchMany(
            ['creating', 'saving'], $document
        );

        $wr = parent::insertOne($document, $options);

        $this->dispatchMany(
            ['created', 'saved'], $document
        );

        return $wr;
    }

    /**
     * Delete the document
     *
     * @param  array|object $document
     * @param  array        $options
     *
     * @return \MongoDB\DeleteResult
     */
    public function delete($document, array $options = [])
    {
        $this->dispatch(
            'deleting', $document
        );

        $wr = parent::deleteOne(['_id' => $document['_id']], $options);

        $this->dispatch(
            'deleted', $document
        );

        return $wr;
    }

    /**
     * Update the document
     *
     * @param  array|object $document
     * @param  array        $options
     *
     * @return \MongoDB\UpdateResult
     */
    public function update($document, array $options = [])
    {
        $this->dispatchMany(
            ['updating', 'saving'], $document
        );

        $wr = parent::updateOne(['_id' => $document['_id']], ['$set' => $document], $options);

        $this->dispatchMany(
            ['updated', 'saved'], $document
        );

        return $wr;
    }
}
