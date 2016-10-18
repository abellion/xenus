<?php

namespace Abellion\ODM\MongoDB;

use MongoDB;

class Repository
{
	public $collection;

	public function __construct(MongoDB\Database $database, string $collectionName, string $entityClass)
	{
		$this->collection = $database->selectCollection($collectionName, [
            "typeMap" => ["root" => $entityClass, "array" => "array", "document" => "array"]
        ]);
	}
}
