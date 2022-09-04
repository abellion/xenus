<?php

namespace Xenus\Tests\Tests\Document\Helpers;

use Xenus\Document;
use Xenus\Document\Helpers\WithHelper;

class WithHelperTest extends \PHPUnit\Framework\TestCase
{
    public function test_with_helper_correctly_keeps_the_given_fields()
    {
        $document = new Document([
            'name' => 'Antoine',
            'city' => 'Paris'
        ]);

        $document = (new WithHelper(['name']))
            ->apply($document);

        $this->assertEquals(
            ['name' => 'Antoine'], $document->toArray()
        );
    }
}
