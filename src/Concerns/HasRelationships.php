<?php

namespace Xenus\Concerns;

use Xenus\Collection;
use Xenus\Exceptions;
use Xenus\Relations;

trait HasRelationships
{
    /**
     * Instantiate a Xenus Collection
     *
     * @param  string $collection
     *
     * @return Collection
     */
    protected function build(string $collection)
    {
        if (null === $this->collection) {
            throw new Exceptions\LogicException(sprintf('Cannot build "%s" collection while document is not connected', $collection));
        }

        return $this->collection->resolve($collection);
    }

    /**
     * Define a "hasOne" relationship
     *
     * @param  string  $target
     * @param  string  $targetKey
     * @param  string  $localKey
     *
     * @return Relations\BindOne
     */
    protected function hasOne(string $target, string $targetKey, string $localKey = '_id')
    {
        $object = $this;
        $target = $this->build($target);

        return new Relations\BindOne($target, $object, $targetKey, $localKey);
    }

    /**
     * Define a "hasMany" relationship
     *
     * @param  string  $target
     * @param  string  $targetKey
     * @param  string  $localKey
     *
     * @return Relations\BindMany
     */
    protected function hasMany(string $target, string $targetKey, string $localKey = '_id')
    {
        $object = $this;
        $target = $this->build($target);

        return new Relations\BindMany($target, $object, $targetKey, $localKey);
    }

    /**
     * Define a "belongsTo" relationship
     *
     * @param  string $target
     * @param  string $localKey
     * @param  string $targetKey
     *
     * @return Relations\BindOne
     */
    protected function belongsTo(string $target, string $localKey, string $targetKey = '_id')
    {
        $object = $this;
        $target = $this->build($target);

        return new Relations\BindOne($target, $object, $targetKey, $localKey);
    }

    /**
     * Define a "belongsToMany" relationship
     *
     * @param  string $target
     * @param  string $localKey
     * @param  string $targetKey
     *
     * @return Relations\BindMany
     */
    protected function belongsToMany(string $target, string $localKey, string $targetKey = '_id')
    {
        $object = $this;
        $target = $this->build($target);

        return new Relations\BindMany($target, $object, $targetKey, $localKey);
    }
}
