<?php

namespace Xenus\Tests;

use MongoDB\Client;
use MongoDB\BSON\ObjectID;

use Xenus\Document as XenusDocument;
use Xenus\Collection as XenusCollection;
use MongoDB\Collection as MongoDBCollection;

class CollectionTest extends TestCase
{
    private $client;
    private $database;

    public function setUp()
    {
        $this->client = new Client(getenv('MONGODB_URI'));
        $this->database = $this->client->{getenv('MONGODB_DATABASE')};
    }

    public function tearDown()
    {
        $this->database->drop();
    }

    public function testIsMongoCollection()
    {
        $cities = new Cities($this->database);

        $this->assertInstanceOf(MongoDBCollection::class, $cities);
    }

    public function testCollectionName()
    {
        $cities = new Cities($this->database);

        $this->assertEquals('cities', $cities->getCollectionName());
    }

    public function testDefaultTypeMap()
    {
        $cities = new Cities($this->database);

        $city = $cities->insertOne([
            'name' => 'Paris',
            'zips' => [75000, 75001, 75002],
            'demography' => new XenusDocument()
        ]);

        $city = $cities->findOne(['_id' => $city->getInsertedId()]);

        $this->assertInstanceOf(XenusDocument::class, $city);
        $this->assertInternalType('array', $city->zips);
        $this->assertInternalType('array', $city->demography);
        $this->assertInternalType('string', $city->name);
    }

    public function testInsert()
    {
        $city = ['name' => 'Paris'];
        $cities = new Cities($this->database);

        $this->assertInstanceOf(\MongoDB\InsertOneResult::class, $cities->insert($city));
        $this->assertInstanceOf(\MongoDB\InsertOneResult::class, $cities->insert(new XenusDocument($city)));
    }

    public function testUpdate()
    {
        $city = ['name' => 'Paris'];
        $cities = new Cities($this->database);

        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $cities->update($city));
        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $cities->update(new XenusDocument($city)));
    }

    public function testDelete()
    {
        $city = ['name' => 'Paris'];
        $cities = new Cities($this->database);

        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $cities->delete($city));
        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $cities->delete(new XenusDocument($city)));
    }

    public function testFindOne()
    {
        $cities = new Cities($this->database);

        $this->assertNull($cities->findOne(new ObjectID()));
        $this->assertNull($cities->findOne(['_id' => new ObjectID()]));
    }

    public function testDeleteOne()
    {
        $cities = new Cities($this->database);

        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $cities->deleteOne(new ObjectID()));
        $this->assertInstanceOf(\MongoDB\DeleteResult::class, $cities->deleteOne(['_id' => new ObjectID()]));
    }

    public function testUpdateOne()
    {
        $cities = new Cities($this->database);
        $update = ['$set' => ['field' => 'value']];

        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $cities->updateOne(new ObjectID(), $update));
        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $cities->updateOne(['_id' => new ObjectID()], $update));
    }

    public function testReplaceOne()
    {
        $cities = new Cities($this->database);

        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $cities->replaceOne(new ObjectID(), []));
        $this->assertInstanceOf(\MongoDB\UpdateResult::class, $cities->replaceOne(['_id' => new ObjectID()], []));
    }
}

class Cities extends XenusCollection
{
    const NAME = 'cities';
    // protected $name = 'cities';
}
