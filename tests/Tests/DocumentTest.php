<?php

namespace Xenus\Tests\Tests;

use Xenus\Document;

class DocumentTest extends \PHPUnit\Framework\TestCase
{
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
