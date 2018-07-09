<?php

namespace Xenus\Relations;

class BindMany extends AbstractRelation
{
    /**
     * Find many documents in the target collection
     *
     * @param  array  $filter
     * @param  array  $options
     *
     * @return Cursor
     */
    public function find($filter = [], array $options = [])
    {
        $attribute = $this->object->get($this->primaryKey);

        if (false === is_array($attribute)) {
            $query = $attribute;
        } else {
            $query = ['$in' => $attribute];
        }

        return $this->target->find(array_merge([
            $this->foreignKey => $query
        ], $filter), $options);
    }

    /**
     * Find one document in the target collection
     *
     * @param  array  $filter
     * @param  array  $options
     *
     * @return array|object|null
     */
    public function findOne($filter = [], array $options = [])
    {
        $attribute = $this->object->get($this->primaryKey);

        if (false === is_array($attribute)) {
            $query = $attribute;
        } else {
            $query = ['$in' => $attribute];
        }

        return $this->target->findOne(array_merge([
            $this->foreignKey => $query
        ], $filter), $options);
    }

    /**
     * Count the number of documents in the target collection
     *
     * @param  array  $filter
     * @param  array  $options
     *
     * @return int
     */
    public function count($filter = [], array $options = [])
    {
        $attribute = $this->object->get($this->primaryKey);

        if (false === is_array($attribute)) {
            $query = $attribute;
        } else {
            $query = ['$in' => $attribute];
        }

        return $this->target->count(array_merge([
            $this->foreignKey => $query
        ], $filter), $options);
    }

    /**
     * Distinct the given field in the target collection
     *
     * @param  string $fieldName
     * @param  array  $filter
     * @param  array  $options
     *
     * @return array
     */
    public function distinct($fieldName, $filter = [], array $options = [])
    {
        $attribute = $this->object->get($this->primaryKey);

        if (false === is_array($attribute)) {
            $query = $attribute;
        } else {
            $query = ['$in' => $attribute];
        }

        return $this->target->distinct($fieldName, array_merge([
            $this->foreignKey => $query
        ], $filter), $options);
    }
}
