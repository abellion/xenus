<?php

namespace Xenus\Support;

class Transform
{
    /**
     * Transform the given document
     *
     * @param  mixed $document
     *
     * @return mixed
     */
    public static function document($document)
    {
        return new class($document) extends Transform {
            private $document;

            public function __construct($document)
            {
                $this->document = $document;
            }

            /**
             * Return an instance of the transformer containing the document's data
             *
             * @param  string $transformer
             *
             * @return object
             */
            public function to(string $transformer)
            {
                return new $transformer($this->document);
            }

            /**
             * Pipe the document through the transformers
             *
             * @param  string $transformers
             *
             * @return object
             */
            public function through(string ...$transformers)
            {
                return parent::pipe($this->document, $transformers);
            }
        };
    }

    /**
     * Transform the values of the collection
     *
     * @param  iterable $collection
     *
     * @return array
     */
    public static function collection($collection)
    {
        return new class($collection) extends Transform {
            private $collection;

            public function __construct($collection)
            {
                $this->collection = $collection;
            }

            /**
             * @param  string $transformer
             *
             * @return array
             */
            public function to(string $transformer)
            {
                $collection = [];

                foreach ($this->collection as $document) {
                    $collection[] = new $transformer($document);
                }

                return $collection;
            }

            /**
             * @param  string $transformers
             *
             * @return array
             */
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
