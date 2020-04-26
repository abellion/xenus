<?php

namespace Xenus\Tests\Tests;

use Xenus\Document;
use Xenus\CollectionParameters;

use Xenus\Tests\Support\RefreshDatabase;

class XenusCollectionParametersTest extends \PHPUnit\Framework\TestCase
{
    use RefreshDatabase;

    public function test_the_collection_has_a_default_type_map()
    {
        $options = (new CollectionParameters($this->connection))->getCollectionOptions();

        $this->assertArrayHasKey(
            'typeMap', $options
        );

        $this->assertEquals(
            Document::class, $options['typeMap']['root']
        );
    }

    public function test_the_options_overwrite_the_defaults()
    {
        $options = ['typeMap' => []];

        $options = (new CollectionParameters($this->connection, ['options' => $options]))->getCollectionOptions();

        $this->assertEmpty(
            $options['typeMap']
        );
    }

    public function test_the_given_document_is_taken_in_the_type_map()
    {
        $options = (new CollectionParameters($this->connection, ['document' => MyDocument::class]))->getCollectionOptions();

        $this->assertEquals(
            MyDocument::class, $options['typeMap']['root']
        );
    }

    public function test_the_collection_can_receive_options()
    {
        $options = ['readPreference' => null];

        $options = (new CollectionParameters($this->connection, ['options' => $options]))->getCollectionOptions();

        $this->assertArrayHasKey(
            'readPreference', $options
        );
    }
}
