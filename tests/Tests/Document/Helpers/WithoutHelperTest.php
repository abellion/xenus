<?php

namespace Xenus\Tests\Tests\Document\Helpers;

use Xenus\Document;
use Xenus\Document\Helpers\WithoutHelper;

class WithoutHelperTest extends \PHPUnit\Framework\TestCase
{
    public function test_without_helper_correctly_evicts_the_given_fields()
    {
        $document = new Document([
            'name' => 'Antoine',
            'city' => 'Paris'
        ]);

        $document = (new WithoutHelper(['name']))
            ->apply($document);

        $this->assertEquals(
            ['city' => 'Paris'], $document->toArray()
        );
    }
}
