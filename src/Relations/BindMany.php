<?php

namespace Xenus\Relations;

class BindMany extends AbstractRelation
{
    public function find($filter = [], array $options = [])
    {
        return $this->target->find(array_merge($filter, [
            $this->foreignKey => $this->object->get($this->primaryKey)
        ]), $options);
    }
}
