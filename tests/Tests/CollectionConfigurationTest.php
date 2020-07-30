<?php

namespace Xenus\Tests\Tests;

use Xenus\Document;
use Xenus\CollectionConfiguration;

use Xenus\Tests\Support\SetupCollectionConfigurationTest;

class CollectionConfigurationTest extends \PHPUnit\Framework\TestCase
{
    use SetupCollectionConfigurationTest;

    public function test_the_collection_has_a_default_type_map()
    {
        $options = (new CollectionConfiguration($this->connection))->getCollectionOptions();

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

        $options = (new CollectionConfiguration($this->connection, ['options' => $options]))->getCollectionOptions();

        $this->assertEmpty(
            $options['typeMap']
        );
    }

    public function test_the_given_document_is_taken_in_the_type_map()
    {
        $options = (new CollectionConfiguration($this->connection, ['document' => MyDocument::class]))->getCollectionOptions();

        $this->assertEquals(
            MyDocument::class, $options['typeMap']['root']
        );
    }

    public function test_the_collection_can_receive_options()
    {
        $options = ['readPreference' => null];

        $options = (new CollectionConfiguration($this->connection, ['options' => $options]))->getCollectionOptions();

        $this->assertArrayHasKey(
            'readPreference', $options
        );
    }
}
