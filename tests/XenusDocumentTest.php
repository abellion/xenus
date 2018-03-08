<?php

namespace Xenus\Tests;

use Xenus\Document;

class XenusDocumentTest extends \PHPUnit\Framework\TestCase
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

        $this->assertNull($document->get('age'));
        $this->assertEquals('Antoine', $document->get('name'));
    }

    public function testGetWithDefault()
    {
        $document = new Document();

        $this->assertEquals('Antoine', $document->get('name', 'Antoine'));
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
}
