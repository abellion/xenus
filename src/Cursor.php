<?php

namespace Xenus;

use IteratorIterator;

/**
 * @method \MongoDB\Driver\CursorId getId()
 * @method \MongoDB\Driver\Server getServer()
 * @method bool isDead()
 * @method int key()
 * @method void next()
 * @method void rewind()
 * @method void setTypeMap(array $typemap)
 * @method bool valid()
 * @compatible \MongoDB\Driver\Cursor
 */
class Cursor extends IteratorIterator
{
    use Concerns\HasCollection;

    /**
     * Return the current iterator element
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function current()
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
        $method = [$this->getInnerIterator(), $name];
        if (!is_callable($method)) {
            throw new \InvalidArgumentException($name.' is not callable');
        }

        return call_user_func_array($method, $arguments);
    }
}
