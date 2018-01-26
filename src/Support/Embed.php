<?php

namespace Xenus\Support;

class Embed
{
    /**
     * Return an utility to embed the given class
     *
     * @param  string $document The class to embed
     *
     * @return object
     */
    public static function document(string $document)
    {
        return new class ($document) {
            private $document;

            public function __construct(string $document)
            {
                $this->document = $document;
            }

            /**
             * Embed the document class on the value
             *
             * @param  mixed $value
             *
             * @return object An instance of the document
             */
            public function on($value)
            {
                if ($value instanceof $this->document) {
                    return $value;
                }

                return new $this->document($value);
            }

            /**
             * Embed the document class on every of the "$values" values
             *
             * @param  array  $values
             *
             * @return array
             */
            public function in(array $values)
            {
                return array_map([$this, 'on'], $values);
            }
        };
    }
}
