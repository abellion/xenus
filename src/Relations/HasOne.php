<?php

namespace Xenus\Relations;

class HasOne extends AbstractRelation
{
    public function find($filter = [], array $options = [])
    {
        return $this->target->findOne(array_merge($filter, [
            $this->foreignKey => $this->object->get($this->primaryKey)
        ]), $options);
    }
}
