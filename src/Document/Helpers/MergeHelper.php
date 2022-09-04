<?php

namespace Xenus\Document\Helpers;

use Xenus\Document;

class MergeHelper
{
    /**
     * The set of values that must be merged
     * @var array
     */
    private $values;

    /**
     * Create the helper
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Merge the values into the given document
     * @param  Document $document
     * @return Document
     */
    public function apply(Document $document): Document
    {
        foreach ($this->values as $key => $value) {
            $document->{$key} = $value;
        }

        return $document;
    }
}
