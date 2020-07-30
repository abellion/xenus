<?php

namespace Xenus\Tests\Support;

use Xenus\Tests\Tests\Stubs\CitiesCollection as Cities;

trait SetupCollectionTest
{
    use SetupDatabase, SetupTestsHooks;

    private $setup = [
        'createDatabase', 'createCitiesCollection'
    ];

    private $tearDown = [
        'deleteDatabase'
    ];

    private $cities;

    /**
     * Create the cities collection
     *
     * @return void
     */
    private function createCitiesCollection()
    {
        $this->cities = new Cities($this->connection);
    }
}
