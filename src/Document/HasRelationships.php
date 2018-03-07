<?php

namespace Xenus\Document;

use Xenus\Relations;
use Xenus\Exceptions;
use Xenus\Collection;
use MongoDB\Database;

trait HasRelationships
{
    /**
     * Instantiate a Xenus Collection
     *
     * @param  string $target
     *
     * @return Collection
     */
    private function buildCollection(string $target)
    {
        if (null === $this->collection) {
            throw new Exceptions\LogicException(sprintf('Target collection "%s" is not buildable', $target));
        }

        if (false === class_exists($target)) {
            throw new Exceptions\InvalidArgumentException(sprintf('Target collection "%s" does not exist', $target));
        }

        return new Collection(new Database($this->collection->getManager(), $this->collection->getDatabaseName()), [
            'name' => $target::NAME,
            'document' => $target::DOCUMENT
        ]);
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
        $target = $this->buildCollection($target);

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
        $target = $this->buildCollection($target);

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
        $target = $this->buildCollection($target);

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
        $target = $this->buildCollection($target);

        return new Relations\BindMany($target, $object, $targetKey, $localKey);
    }
}
