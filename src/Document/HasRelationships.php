<?php

namespace Xenus\Document;

use Xenus\Exceptions;
use Xenus\Collection;
use MongoDB\Database;

trait HasRelationships
{
    public function buildCollection(string $target)
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

    protected function hasOne(string $target, string $targetKey, string $localKey = '_id')
    {
        $object = $this;
        $target = $this->buildCollection($target);

        return new Xenus\Relations\BindOne($target, $object, $targetKey, $localKey);
    }

    protected function hasMany(string $target, string $targetKey, string $localKey = '_id')
    {
        $object = $this;
        $target = $this->buildCollection($target);

        return new Xenus\Relations\BindMany($target, $object, $targetKey, $localKey);
    }

    protected function belongsTo(string $target, string $localKey, string $targetKey = '_id')
    {
        $object = $this;
        $target = $this->buildCollection($target);

        return new Xenus\Relations\BindOne($target, $object, $targetKey, $localKey);
    }

    protected function belongsToMany(string $target, string $localKey, string $targetKey = '_id')
    {
        $object = $this;
        $target = $this->buildCollection($target);

        return new Xenus\Relations\BindMany($target, $object, $targetKey, $localKey);
    }
}
