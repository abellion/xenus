<?php

namespace Xenus\Document;

trait HasHelpers
{
    /**
     * Merge the given values within the document
     *
     * @param  array  $values
     *
     * @return self
     */
    public function merge(array $values): self
    {
        $helper = new Helpers\MergeHelper($values);

        return $helper->apply($this);
    }

    /**
     * Return a new document containing only the specified values
     *
     * @param  array  $fields
     *
     * @return self
     */
    public function with(array $fields): self
    {
        $helper = new Helpers\WithHelper($fields);

        return $helper->apply($this);
    }

    /**
     * Return a new document without the specified values
     *
     * @param  array  $fields
     *
     * @return self
     */
    public function without(array $fields): self
    {
        $helper = new Helpers\WithoutHelper($fields);

        return $helper->apply($this);
    }
}
