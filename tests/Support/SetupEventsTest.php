<?php

namespace Xenus\Tests\Support;

use Xenus\Tests\Tests\Stubs\TokensCollection as Tokens;

trait SetupEventsTest
{
    use RefreshDatabase;

    public function setUp()
    {
        $this->createDatabase();
    }
}
