<?php

namespace Xenus\Tests\Tests\Document\Helpers;

use Xenus\Document;
use Xenus\Document\Helpers\MergeHelper;

class MergeHelperTest extends \PHPUnit\Framework\TestCase
{
    public function test_merge_helper_correctly_merges_the_given_fields()
    {
        $document = new Document([
            'name' => 'Antoine'
        ]);

        $document = (new MergeHelper(['city' => 'Paris']))
            ->apply($document);

        $this->assertEquals(
            'Paris', $document->get('city')
        );
    }
}
