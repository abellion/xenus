<?php

namespace Xenus\Tests\Support;

trait SetupTestsHooks
{
    /**
     * Call the setup hooks
     *
     * @return void
     */
    protected function setUp()
    {
        foreach ($this->setup ?? [] as $setup) {
            call_user_func([$this, $setup]);
        }
    }

    /**
     * Call the tear down hooks
     *
     * @return void
     */
    protected function tearDown()
    {
        foreach ($this->tearDown ?? [] as $tearDown) {
            call_user_func([$this, $tearDown]);
        }
    }
}
