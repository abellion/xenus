<?php

namespace Xenus\Tests\Tests;

use Xenus\Document;
use Xenus\Support\Embed;

class EmbedTest extends \PHPUnit\Framework\TestCase
{
    public function test_embeding_on_documents_works()
    {
        $document = Embed::document(Document::class)->on($family = new Document([
            'mother' => 'Chris',
            'father' => 'Dominique'
        ]));

        $this->assertInstanceOf(
            Document::class, $document
        );

        $this->assertEquals(
            $family->toArray(), $document->toArray()
        );
    }

    public function test_embeding_on_arrays_works()
    {
        $document = Embed::document(Document::class)->on($family = [
            'mother' => 'Chris',
            'father' => 'Dominique'
        ]);

        $this->assertInstanceOf(
            Document::class, $document
        );

        $this->assertEquals(
            $family, $document->toArray()
        );
    }

    public function test_embeding_in_multiple_arrays_works()
    {
        $documents = Embed::document(Document::class)->in($browsers = [
            ['name' => 'Nicolas', 'age' => 25],
            ['name' => 'Obon', 'age' => 19]
        ]);

        $this->assertTrue(
            is_array($documents)
        );

        $this->assertCount(
            2, $documents
        );
    }
}
