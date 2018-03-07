<?php

namespace Xenus\Relations;

use Xenus\Document;
use Xenus\Collection;
use Xenus\Exceptions;

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

        if (false === $this->object->has($this->primaryKey)) {
            throw new Exceptions\LogicException(sprintf('The `%s` model does not have any `%s` attribute', get_class($object), $primaryKey));
        }
    }
}
