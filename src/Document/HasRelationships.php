<?php

namespace Xenus\Document;

trait HasRelationships
{
    protected function hasOne(string $target, string $targetKey, string $localKey = '_id')
    {
        $target = null;
        $object = $this;

        return new Xenus\Relations\BindOne($target, $object, $targetKey, $localKey);
    }

    protected function hasMany(string $target, string $targetKey, string $localKey = '_id')
    {
        $target = null;
        $object = $this;

        return new Xenus\Relations\BindMany($target, $object, $targetKey, $localKey);
    }

    protected function belongsTo(string $target, string $localKey, string $targetKey = '_id')
    {
        $target = null;
        $object = $this;

        return new Xenus\Relations\BindOne($target, $object, $targetKey, $localKey);
    }

    protected function belongsToMany(string $target, string $localKey, string $targetKey = '_id')
    {
        $target = null;
        $object = $this;

        return new Xenus\Relations\BindMany($target, $object, $targetKey, $localKey);
    }
}
