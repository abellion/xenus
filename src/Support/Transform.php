<?php

namespace Xenus\Support;

class Transform
{
    public static function document($document)
    {
        return new class($document) extends Transform {
            private $document;

            public function __construct($document)
            {
                $this->document = $document;
            }

            public function to(string $transformer)
            {
                return new $transformer($this->document);
            }

            public function through(string ...$transformers)
            {
                return parent::pipe($this->document, $transformers);
            }
        };
    }

    public static function collection($collection)
    {
        return new class($collection) extends Transform {
            private $collection;

            public function __construct($collection)
            {
                $this->collection = $collection;
            }

            public function to(string $transformer)
            {
                $collection = [];

                foreach ($this->collection as $document) {
                    $collection[] = new $transformer($document);
                }

                return $collection;
            }

            public function through(string ...$transformers)
            {
                $collection = [];

                foreach ($this->collection as $document) {
                    $collection[] = parent::pipe($document, $transformers);
                }

                return $collection;
            }
        };
    }

    protected static function pipe($document, array $transformers)
    {
        foreach ($transformers as $transformer) {
            $document = new $transformer($document);
        }

        return $document;
    }
}
