<?php

namespace Xenus\Support;

use Xenus\Document;

class Embed
{
    public static function document(string $document)
    {
        return new class ($document) {
            private $document;

            public function __construct(string $document)
            {
                $this->document = $document;
            }

            public function on($value)
            {
                if ($value instanceof $this->document) {
                    return $value;
                }

                return new $this->document($value);
            }

            public function in(array $values)
            {
                return array_map([$this, 'on'], $values);
            }
        };
    }
}
