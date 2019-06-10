<?php

namespace Xenus;

class Options
{
    /**
     * The default collection's options
     * @var array
     */
    private $options = [
        'document' => Document::class
    ];

    public function __construct(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Return the options
     *
     * @return array
     */
    public function all()
    {
        return [
        ];
    }

    /**
     * Build the options based on the given object's properties
     *
     * @param  mixed $collection
     *
     * @return Options
     */
    public static function from($collection)
    {
        $options = [];

        foreach (['name', 'document'] as $property) {
            $options[$property] = $collection->{$property};
        }

        return new self($options);
    }
}
