<?php

namespace Xenus\Concerns;

use Xenus\Collection;

trait HasCollection
{
    /**
     * @var Collection|null
     */
    protected ?Collection $collection = null;

    /**
     * Set the collection this object is coming from
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
    public function collection() : ?Collection
    {
        return $this->collection;
    }
}
