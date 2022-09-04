<?php

namespace Xenus\Document\Helpers;

use Xenus\Document;

class WithHelper
{
    /**
     * The fields that must be kept within the document
     *
     * @var array
     */
    private $fields;

    /**
     * Create the helper
     *
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Create a new document containing only the given fields
     *
     * @param  Document $document
     *
     * @return Document
     */
    public function apply(Document $document): Document
    {
        $document = clone $document;

        foreach ($document->toArray() as $key => $value) {
            if (in_array($key, $this->fields) !== true) {
                unset($document[$key]);
            }
        }

        return $document;
    }
}
