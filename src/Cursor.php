<?php

namespace Xenus;

use IteratorIterator;

class Cursor extends IteratorIterator
{
    use Concerns\HasCollection;

    /**
     * Return the current iterator element
     *
     * @return mixed
     */
    public function current(): mixed
    {
        $document = parent::current();

        if ($document instanceof Document && isset($this->collection)) {
            $document->connect($this->collection);
        }

        return $document;
    }

    /**
     * Transform the Cursor into an array
     *
     * @return array
     */
    public function toArray(): array
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
        return call_user_func_array([$this->getInnerIterator(), $name], $arguments);
    }
}
