<?php

namespace Xenus\Tests\Unit;

use Xenus\Document;

class XenusDocumentTest extends \PHPUnit\Framework\TestCase
{
    public function test_has_method()
    {
        $document = new Document([
            'name' => 'Antoine'
        ]);

        $this->assertTrue(
            $document->has('name')
        );

        $this->assertFalse(
            $document->has('city')
        );
    }

    public function test_get_method()
    {
        $document = new Document([
            'name' => 'Antoine'
        ]);

        $this->assertNull(
            $document->get('age')
        );

        $this->assertEquals(
            'Antoine', $document->get('name')
        );
    }

    public function test_get_method_can_returns_a_default_value()
    {
        $document = new Document([
            'name' => 'Antoine'
        ]);

        $this->assertEquals(
            '24', $document->get('age', '24')
        );

        $this->assertEquals(
            'Antoine', $document->get('name', '24')
        );
    }

    public function test_set_method()
    {
        $document = new Document([
            'name' => 'Antoine'
        ]);

        $document->set(
            'name', 'Nicolas'
        );

        $this->assertEquals(
            'Nicolas', $document->get('name')
        );
    }

    public function test_fill_method()
    {
        $document = new Document();

        $document->fill([
            'name' => 'Antoine'
        ]);

        $this->assertEquals(
            ['name' => 'Antoine'], $document->toArray()
        );
    }

    public function test_with_method()
    {
        $document = new class extends Document {
            protected $withId = true;
        };

        $document = $document->fill([
            'name' => 'Antoine', 'city' => 'Paris'
        ]);

        $this->assertEquals(
            [], $document->with([])->toArray()
        );

        $this->assertEquals(
            ['name' => 'Antoine'], $document->with(['name'])->toArray()
        );

        $this->assertEquals(
            ['name' => 'Antoine'], $document->with(['name', 'unknown'])->toArray()
        );
    }

    public function test_without_method()
    {
        $document = new class extends Document {
            protected $withId = true;
        };

        $document = $document->fill([
            'name' => 'Antoine', 'city' => 'Paris'
        ]);

        $this->assertEquals(
            ['name' => 'Antoine', '_id' => $document['_id']], $document->without(['city'])->toArray()
        );

        $this->assertEquals(
            ['name' => 'Antoine', 'city' => 'Paris'], $document->without(['_id'])->toArray()
        );
    }

    public function test_get_from_getter_method()
    {
        $document = new class extends Document {
            public function getName()
            {
                return 'Antoine';
            }
        };

        $this->assertEquals(
            'Antoine', $document->getFromGetter('name')
        );
    }

    public function test_set_from_setter_method()
    {
        $document = new class extends Document {
            public function setName($name)
            {
                return $this->set('name', $name);
            }
        };

        $this->assertEquals(
            'Charles', $document->setFromSetter('name', 'Charles')->get('name')
        );
    }

    public function test_with_id_configuration()
    {
        $document = new class extends Document {
            protected $withId = false;
        };

        $this->assertNull(
            $document['_id']
        );

        $document = new class extends Document {
            protected $withId = true;
        };

        $this->assertInstanceOf(
            \MongoDB\BSON\ObjectID::class, $document['_id']
        );
    }
}
