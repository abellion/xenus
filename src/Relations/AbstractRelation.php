<?php

namespace Xenus\Relations;

use Xenus\Document;
use Xenus\Collection;

abstract class AbstractRelation
{
    protected $target;
    protected $object;

    protected $foreignKey = null;
    protected $primaryKey = null;

    public function __construct(Collection $target, Document $object, string $foreignKey, string $primaryKey)
    {
        $this->target = $target;
        $this->object = $object;

        $this->foreignKey = $foreignKey;
        $this->primaryKey = $primaryKey;
    }
}
