<?php

namespace Xenus;

use MongoDB\Database;
use MongoDB\Collection as BaseCollection;

abstract class Collection extends BaseCollection
{
    protected $name;
    protected $document = Document::class;

    public function __construct(Database $database)
    {
        parent::__construct($database->getManager(), $database->getDatabaseName(), $this->name, [
            'typeMap' => ['root' => $this->document, 'array' => 'array', 'document' => 'array']
        ]);
    }
}
