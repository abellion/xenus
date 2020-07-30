<?php

namespace Xenus\Concerns;

use Xenus\CollectionResolver as Resolver;

trait HasCollectionResolver
{
    protected $resolver;

    /**
     * Resolve the given collection
     *
     * @param  string $collection
     *
     * @return Collection
     */
    public function resolve(string $collection)
    {
        if (isset($this->resolver) === false && class_exists($collection) === false) {
            throw new Exceptions\InvalidArgumentException(sprintf('Target collection "%s" is not resolvable', $collection));
        }

        if (isset($this->resolver) === false) {
            return new $collection($this->configuration->getCollectionConnection());
        }

        return $this->resolver->resolve($collection);
    }

    /**
     * Set the collection resolver
     *
     * @param  Resolver $resolver
     *
     * @return self
     */
    public function setCollectionResolver(Resolver $resolver)
    {
        $this->resolver = $resolver;

        return $this;
    }
}
