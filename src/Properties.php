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
     * Get the collection's options
     *
     * @return Array
     */
    public function getCollectionOptions()
    {
        $options = ['typeMap' => ['root' => $this->properties->document, 'array' => 'array', 'document' => 'array']];

        if (isset($this->properties->options)) {
            return array_merge($this->properties->options, $options);
        }

        return $options;
    }

    /**
     * Get the collection's name
     *
     * @return String|null
     */
    public function getCollectionName()
    {
        if (isset($this->properties['name'])) {
            return $this->properties['name'];
        }

        return null;
    }

    /**
     * Determine if the properties have the given proeprty
     *
     * @param  string $property
     *
     * @return bool
     */
    public function have(string $property) {
        if (isset($this->properties[$property])) {
            return true;
        }

        return false;
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
