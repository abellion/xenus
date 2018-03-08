<?php

namespace Xenus\Concerns;

use Xenus\Collection;

trait HasCollection
{
    protected $collection = null;

    /**
     * Set the collection this object is comming from
     *
     * @param  Collection $collection
     *
     * @return self
     */
    public function connect(Collection $collection)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Retrieve the connected collection
     *
     * @return null|Collection
     */
    public function collection()
    {
        return $this->collection;
    }
}
