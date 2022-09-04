<?php

namespace Xenus\Document\Support;

use Xenus\Document;

class DynamicProperties
{
    /**
     * Find a getter corresponding to the given property
     * @param  Document $document
     * @param  string   $property
     * @return callable
     */
    public static function findGetter(Document $document, string $property): callable
    {
        $getter = static::getterIze($property);

        if (method_exists($document, $getter)) {
            return [$document, $getter];
        }

        return function () use ($document, $property) {
            return $document->get($property);
        };
    }

    /**
     * Create a getter name out of a property
     * @param  string $property
     * @return string
     */
    protected static function getterIze(string $property): string
    {
        return 'get' . str_replace(' ', '', ucwords(strtr($property, '_-', '  ')));
    }

    /**
     * Find a setter corresponding to the given property
     * @param  Document $document
     * @param  string   $property
     * @return callable
     */
    public static function findSetter(Document $document, string $property): callable
    {
        $setter = static::setterIze($property);

        if (method_exists($document, $setter)) {
            return [$document, $setter];
        }

        return function ($value) use ($document, $property) {
            return $document->set($property, $value);
        };
    }

    /**
     * Create a setter name out of a property
     * @param  string $property
     * @return string
     */
    protected static function setterIze(string $property): string
    {
        return 'set' . str_replace(' ', '', ucwords(strtr($property, '_-', '  ')));
    }
}
