<?php

namespace Xenus\Tests\Tests;

use Xenus\Document;

class DocumentTest extends \PHPUnit\Framework\TestCase
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

    public function test_with_id_configuration()
    {
        $document = new class extends Document {
            protected $withId = false;
        };

        $this->assertNull(
            $document->get('_id')
        );

        $document = new class extends Document {
            protected $withId = true;
        };

        $this->assertInstanceOf(
            \MongoDB\BSON\ObjectID::class, $document->get('_id')
        );
    }

    public function test_a_document_can_be_constructed_with_with_another_document()
    {
        $document = new Document(
            new Document([
                'name' => 'Antoine'
            ])
        );

        $this->assertEquals(
            ['name' => 'Antoine'], $document->toArray()
        );
    }
}
