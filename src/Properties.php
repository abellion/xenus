<?php

namespace Xenus;

class Properties
{
    /**
     * The default collection's properties
     * @var array
     */
    private $properties = [
        'document' => Document::class
    ];

    public function __construct(array $properties)
    {
        $this->properties = array_merge($this->properties, $properties);
    }

    /**
     * Build the properties based on the given object
     *
     * @param  mixed $collection
     *
     * @return Options
     */
    public static function from($collection)
    {
        $properties = [];

        foreach (['name', 'document'] as $property) {
            $properties[$property] = $collection->{$property};
        }

        return new self(array_filter($properties));
    }
}
