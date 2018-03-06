<?php

namespace Xenus;

use Traversable;
use IteratorIterator;

class Cursor extends IteratorIterator
{
    private $iterator;
    private $collection;

    public function __construct(Traversable $iterator, Collection $collection)
    {
        $this->iterator = $iterator;
        $this->collection = $collection;

        parent::__construct($iterator);
    }

    /**
     * Return the current iterator element
     *
     * @return mixed
     */
    public function current()
    {
        $document = parent::current();

        if ($document instanceof Document) {
            $document->connect($this->collection);
        }

        return $document;
    }

    /**
     * Transform the Cursor into an array
     *
     * @return array
     */
    public function toArray()
    {
        $documents = [];

        foreach ($this as $document) {
            $documents[] = $document;
        }

        return $documents;
    }

    /**
     * Forward methods calls to the inner iterator
     *
     * @param  string $name
     * @param  array  $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->iterator, $name], $arguments);
    }
}
