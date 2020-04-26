<?php

namespace Xenus\Tests\Tests;

use MongoDB\BSON\ObjectID;

use Xenus\Document as XenusDocument;
use Xenus\Tests\Support\SetupCollectionTest;

class XenusCollectionTest extends \PHPUnit\Framework\TestCase
{
    use SetupCollectionTest;

    public function testInsert()
    {
        $city = ['name' => 'Paris'];

        $this->assertInstanceOf(\MongoDB\InsertOneResult::class, $this->cities->insert($city));
        $this->assertInstanceOf(\MongoDB\InsertOneResult::class, $this->cities->insert(new XenusDocument($city)));
    }

    public function testUpdate()
    {
        $city = ['name' => 'Paris'];

        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $this->cities->update($city));
        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $this->cities->update(new XenusDocument($city)));
    }

    public function testDelete()
    {
        $city = ['name' => 'Paris'];

        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $this->cities->delete($city));
        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $this->cities->delete(new XenusDocument($city)));
    }

    public function testFindOne()
    {
        $this->assertNull($this->cities->findOne(new ObjectID()));
        $this->assertNull($this->cities->findOne(['_id' => new ObjectID()]));
    }

    public function testDeleteOne()
    {
        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $this->cities->deleteOne(new ObjectID()));
        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $this->cities->deleteOne(['_id' => new ObjectID()]));
    }

    public function testUpdateOne()
    {
        $update = ['$set' => ['field' => 'value']];

        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $this->cities->updateOne(new ObjectID(), $update));
        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $this->cities->updateOne(['_id' => new ObjectID()], $update));
    }

    public function testReplaceOne()
    {
        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $this->cities->replaceOne(new ObjectID(), []));
        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $this->cities->replaceOne(['_id' => new ObjectID()], []));
    }

    public function testFindOneAndDelete()
    {
        $this->assertNull($this->cities->findOneAndDelete(new ObjectID()));
        $this->assertNull($this->cities->findOneAndDelete(['_id' => new ObjectID()]));
    }

    public function testFindOneAndUpdate()
    {
        $update = ['$set' => ['field' => 'value']];

        $this->assertNull($this->cities->findOneAndUpdate(new ObjectID(), $update));
        $this->assertNull($this->cities->findOneAndUpdate(['_id' => new ObjectID()], $update));
    }

    public function testFindOneAndReplace()
    {
        $this->assertNull($this->cities->findOneAndReplace(new ObjectID(), []));
        $this->assertNull($this->cities->findOneAndReplace(['_id' => new ObjectID()], []));
    }
}
