<?php

namespace Xenus\Tests\Support;

use Xenus\Tests\Tests\Stubs\CitiesCollection as Cities;

trait SetupCollectionTest
{
    use RefreshDatabase;

    private $cities;

    public function setUp()
    {
        $this->createDatabase();

        $this->cities = new Cities($this->connection);
    }
}
