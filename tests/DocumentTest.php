<?php

use Xenus\Document;

use PHPUnit\Framework\TestCase;

class DocumentTest extends TestCase
{
    public function testHas()
    {
        $document = new Document();

        $document->set('name', 'Antoine');

        $this->assertTrue($document->has('name'));
        $this->assertFalse($document->has('city'));
    }

    public function testGet()
    {
        $document = new Document();

        $document->set('name', 'Antoine');

        $this->assertEquals('Antoine', $document->get('name'));
    }

    public function testSet()
    {
        $document = new Document();

        $document->set('name', 'Antoine');

        $this->assertEquals(['name' => 'Antoine'], $document->toArray());
    }

    public function testFill()
    {
        $document = new Document();

        $document->fill(['name' => 'Antoine']);

        $this->assertEquals(['name' => 'Antoine'], $document->toArray());
    }

    public function testWith()
    {
        $document = new class extends Document {
            protected $withId = true;
        };

        $document = $document->fill(['name' => 'Antoine', 'city' => 'Paris']);

        $this->assertEquals([], $document->with([])->toArray());
        $this->assertEquals(['name' => 'Antoine'], $document->with(['name'])->toArray());
        $this->assertEquals(['name' => 'Antoine'], $document->with(['name', 'unknown'])->toArray());
    }

    public function testWithout()
    {
        $document = new class extends Document {
            protected $withId = true;
        };

        $document = $document->fill(['name' => 'Antoine', 'city' => 'Paris']);

        $this->assertEquals(['name' => 'Antoine', '_id' => $document['_id']], $document->without(['city'])->toArray());
        $this->assertEquals(['name' => 'Antoine', 'city' => 'Paris'], $document->without(['_id'])->toArray());
    }

    public function testGetFromGetter()
    {
        $document = new class extends Document {
            public function getName()
            {
                return 'Antoine';
            }
        };

        $this->assertEquals('Antoine', $document->getFromGetter('name'));
    }

    public function testSetFromSetter()
    {
        $document = new class extends Document {
            public function setName($name)
            {
                return $this->set('name', 'Antoine');
            }
        };

        $this->assertEquals('Antoine', $document->setFromSetter('name', 'Charles')->get('name'));

        $document = new class extends Document {
            public function setName($name)
            {
                return $this->set('name', $name);
            }
        };

        $this->assertEquals('Charles', $document->setFromSetter('name', 'Charles')->get('name'));
    }

    public function testEmbedOn()
    {
        $document = new Document();

        $family = [
            'mother' => 'Chris',
            'father' => 'Dominique'
        ];

        $document->embed(Document::class)->on($family)->as('family');

        $this->assertInstanceOf(Document::class, $document->family);
        $this->assertEquals($family, $document->family->toArray());
    }

    public function testEmbedIn()
    {
        $document = new Document();

        $browsers = [
            ['name' => 'Nicolas', 'age' => 25],
            ['name' => 'Obon', 'age' => 19]
        ];

        $document->embed(Document::class)->in($browsers)->as('browsers');

        $this->assertTrue(is_array($document->browsers));
        $this->assertEquals(2, count($document->browsers));
        $this->assertInstanceOf(Document::class, $document->browsers[0]);
    }
}
