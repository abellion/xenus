<?php

use MongoDB\Client;
use PHPUnit\Framework\TestCase;

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
}

class Cities extends XenusCollection
{
    protected $name = 'cities';
}
