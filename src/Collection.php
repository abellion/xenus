<?php

namespace Abellion\Xenus;

use MongoDB\Database;

class Collection
{
	protected $name;
	protected $document = Document::class;

	public $collection;

	public function __construct(Database $database)
	{
		$this->collection = $database->selectCollection($this->name, [
			'typeMap' => ['root' => $this->document, 'document' => Document::class, 'array' => 'array']
		]);
	}

}
