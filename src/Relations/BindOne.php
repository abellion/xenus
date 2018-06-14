<?php

namespace Xenus\Relations;

class BindOne extends AbstractRelation
{
    /**
     * Find one document in the target collection
     *
     * @param  array  $filter
     * @param  array  $options
     *
     * @return mixed
     */
    public function find($filter = [], array $options = [])
    {
        return $this->target->findOne(array_merge([
            $this->foreignKey => $this->object->get($this->primaryKey)
        ], $filter), $options);
    }
}
