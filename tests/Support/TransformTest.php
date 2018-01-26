<?php

namespace Xenus\Tests;

use Xenus\Document;
use Xenus\Tests\TestCase;
use Xenus\Support\Transform;

use MongoDB\BSON\ObjectID;

class TransformTest extends TestCase
{
    public function testTransformDocument()
    {
        $city = new Document(['_id' => new ObjectID(), 'name' => 'Paris', 'zip' => 75000]);
        $city = Transform::document($city)->to(CityTransformer::class);

        $this->assertInstanceOf(CityTransformer::class, $city);
        $this->assertEquals(3, count($city->toArray()));
        $this->assertTrue($city->has('zip_code'));
        $this->assertTrue(is_string($city['_id']));
    }

    public function testTransformCollection()
    {
        $cities = Transform::collection([
            new Document(['name' => 'Paris', 'zip' => 75000]),
            new Document(['name' => 'Clermont', 'zip' => 63000])
        ])->to(CityTransformer::class);

        $this->assertTrue(is_array($cities));
        $this->assertEquals(2, count($cities));
        $this->assertInstanceOf(CityTransformer::class, $cities[0]);
        $this->assertInstanceOf(CityTransformer::class, $cities[1]);
    }
}

class CityTransformer extends Document
{
    public function setId($id)
    {
        return $this->set('_id', (string) $id);
    }

    public function setZip($zip)
    {
        return $this->set('zip_code', $zip);
    }
}
