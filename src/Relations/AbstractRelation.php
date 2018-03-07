<?php

namespace Xenus\Relations;

use Xenus\Document;
use Xenus\Collection;
use Xenus\Exceptions;

abstract class AbstractRelation
{
    /**
     * The target collection
     * @var Collection
     */
    protected $target;

    /**
     * The subject document of the relation
     * @var Document
     */
    protected $object;

    /**
     * The key that identify the relation on the target collection
     * @var string
     */
    protected $foreignKey = null;

    /**
     * The key that uniquely identify the subject document
     * @var string
     */
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
