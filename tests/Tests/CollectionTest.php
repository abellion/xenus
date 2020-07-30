<?php

namespace Xenus\Tests\Tests;

use MongoDB\BSON\ObjectID;

use Xenus\Document as XenusDocument;
use Xenus\Tests\Support\SetupCollectionTest;

class CollectionTest extends \PHPUnit\Framework\TestCase
{
    use SetupCollectionTest;

    public function test_insert_method()
    {
        $city = ['name' => 'Paris'];

        $this->assertInstanceOf(
            \MongoDB\InsertOneResult::class, $this->cities->insert($city)
        );

        $this->assertInstanceOf(
            \MongoDB\InsertOneResult::class, $this->cities->insert(new XenusDocument($city))
        );
    }

    public function test_update_method()
    {
        $city = ['name' => 'Paris'];

        $this->assertInstanceOf(
            \MongoDB\UpdateResult::class, $this->cities->update($city)
        );

        $this->assertInstanceOf(
            \MongoDB\UpdateResult::class, $this->cities->update(new XenusDocument($city))
        );
    }

    public function test_delete_method()
    {
        $city = ['name' => 'Paris'];

        $this->assertInstanceOf(
            \MongoDB\DeleteResult::class, $this->cities->delete($city)
        );

        $this->assertInstanceOf(
            \MongoDB\DeleteResult::class, $this->cities->delete(new XenusDocument($city))
        );
    }

    public function test_find_one_method()
    {
        $this->assertNull(
            $this->cities->findOne(new ObjectID())
        );

        $this->assertNull(
            $this->cities->findOne(['_id' => new ObjectID()])
        );
    }

    public function test_delete_one_method()
    {
        $this->assertInstanceOf(
            \MongoDB\DeleteResult::class, $this->cities->deleteOne(new ObjectID())
        );

        $this->assertInstanceOf(
            \MongoDB\DeleteResult::class, $this->cities->deleteOne(['_id' => new ObjectID()])
        );
    }

    public function test_update_one_method()
    {
        $update = ['$set' => ['field' => 'value']];

        $this->assertInstanceOf(
            \MongoDB\UpdateResult::class, $this->cities->updateOne(new ObjectID(), $update)
        );

        $this->assertInstanceOf(
            \MongoDB\UpdateResult::class, $this->cities->updateOne(['_id' => new ObjectID()], $update)
        );
    }

    public function test_replace_one_method()
    {
        $this->assertInstanceOf(
            \MongoDB\UpdateResult::class, $this->cities->replaceOne(new ObjectID(), [])
        );

        $this->assertInstanceOf(
            \MongoDB\UpdateResult::class, $this->cities->replaceOne(['_id' => new ObjectID()], [])
        );
    }

    public function test_find_one_and_delete_method()
    {
        $this->assertNull(
            $this->cities->findOneAndDelete(new ObjectID())
        );

        $this->assertNull(
            $this->cities->findOneAndDelete(['_id' => new ObjectID()])
        );
    }

    public function test_find_one_and_update_method()
    {
        $update = ['$set' => ['field' => 'value']];

        $this->assertNull(
            $this->cities->findOneAndUpdate(new ObjectID(), $update)
        );

        $this->assertNull(
            $this->cities->findOneAndUpdate(['_id' => new ObjectID()], $update)
        );
    }

    public function test_find_one_and_replace_method()
    {
        $this->assertNull(
            $this->cities->findOneAndReplace(new ObjectID(), [])
        );

        $this->assertNull(
            $this->cities->findOneAndReplace(['_id' => new ObjectID()], [])
        );
    }
}
