<?php

namespace Abellion\Xenus;

use MongoDB\Database;

abstract class Collection
{
	protected $name;
	protected $document = Document::class;

	public $collection;

	public function __construct(Database $database)
	{
		$this->collection = $database->selectCollection($this->name, [
			'typeMap' => ['root' => $this->document, 'document' => 'array', 'array' => 'array']
		]);
	}

}
