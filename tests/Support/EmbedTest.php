<?php

namespace Xenus\Tests;

use Xenus\Document;
use Xenus\Support\Embed;
use Xenus\Tests\TestCase;

use MongoDB\BSON\ObjectID;

class EmbedTest extends TestCase
{
    public function testEmbedOnArray()
    {
        $document = Embed::document(Document::class)->on($family = [
            'mother' => 'Chris',
            'father' => 'Dominique'
        ]);

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals($family, $document->toArray());
    }

    public function testEmbedOnDocument()
    {
        $document = Embed::document(Document::class)->on($family = new Document([
            'mother' => 'Chris',
            'father' => 'Dominique'
        ]));

        $this->assertInstanceOf(Document::class, $document);
        $this->assertEquals($family->toArray(), $document->toArray());
    }

    public function testEmbedObjectID()
    {
        $id = Embed::document(ObjectID::class)->on('5a6b0649d1e6a5001b739e62');

        $this->assertInstanceOf(ObjectID::class, $id);
        $this->assertEquals((string) $id, '5a6b0649d1e6a5001b739e62');
    }

    public function testEmbedInArray()
    {
        $documents = Embed::document(Document::class)->in($browsers = [
            ['name' => 'Nicolas', 'age' => 25],
            ['name' => 'Obon', 'age' => 19]
        ]);

        $this->assertTrue(is_array($documents));
        $this->assertEquals(2, count($documents));
        $this->assertInstanceOf(Document::class, $documents[0]);
        $this->assertInstanceOf(Document::class, $documents[1]);
        $this->assertEquals($browsers[0], $documents[0]->toArray());
        $this->assertEquals($browsers[1], $documents[1]->toArray());
    }
}
