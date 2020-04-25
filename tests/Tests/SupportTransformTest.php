<?php

namespace Xenus\Tests\Tests;

use MongoDB\BSON\ObjectID;

use Xenus\Document;
use Xenus\Support\Transform;

use Xenus\Tests\Tests\Stubs\CityTransformer;

class SupportTransformTest extends \PHPUnit\Framework\TestCase
{
    public function test_transforming_a_document()
    {
        $document = new Document([
            '_id' => new ObjectID(), 'name' => 'Paris', 'zip' => 75000
        ]);

        $document = Transform::document($document)->to(CityTransformer::class);

        $this->assertInstanceOf(
            CityTransformer::class, $document
        );

        $this->assertCount(
            3, $document->toArray()
        );
    }

    public function test_transforming_a_collection()
    {
        $collection = [
            new Document(['name' => 'Paris', 'zip' => 75000]), new Document(['name' => 'Clermont', 'zip' => 63000])
        ];

        $collection = Transform::collection($collection)->to(CityTransformer::class);

        $this->assertTrue(
            is_array($collection)
        );

        $this->assertEquals(
            2, count($collection)
        );
    }
}
