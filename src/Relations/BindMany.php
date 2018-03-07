<?php

namespace Xenus\Relations;

class BindMany extends AbstractRelation
{
    public function find($filter = [], array $options = [])
    {
        $subject = $this->object->get($this->primaryKey);

        if (false === is_array($subject)) {
            $query = $subject;
        } else {
            $query = ['$in' => $subject];
        }

        return $this->target->find(array_merge($filter, [
            $this->foreignKey => $query
        ]), $options);
    }
}
