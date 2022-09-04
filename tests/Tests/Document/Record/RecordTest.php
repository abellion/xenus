<?php

namespace Xenus\Tests\Tests\Document\Record;

use Xenus\Document\Record\Record;

class RecordTest extends \PHPUnit\Framework\TestCase
{
    public function test_has_method_behaves_correctly()
    {
        $record = new Record([
            'name' => 'Antoine'
        ]);

        $this->assertTrue(
            $record->has('name')
        );

        $this->assertFalse(
            $record->has('city')
        );
    }

    public function test_has_method_returns_true_even_when_the_field_is_null()
    {
        $record = new Record([
            'name' => null
        ]);

        $this->assertTrue(
            $record->has('name')
        );
    }

    public function test_get_method_behaves_correctly()
    {
        $record = new Record([
            'name' => 'Antoine'
        ]);

        $this->assertEquals(
            'Antoine', $record->get('name')
        );
    }

    public function test_get_method_return_null_when_the_field_does_not_exist()
    {
        $record = new Record([
            'name' => 'Antoine'
        ]);

        $this->assertNull(
            $record->get('XXXX')
        );
    }

    public function test_get_method_return_a_default_value_when_the_field_does_not_exist()
    {
        $record = new Record([
            'name' => 'Antoine'
        ]);

        $this->assertEquals(
            42, $record->get('age', 42)
        );
    }

    public function test_set_method_behaves_correctly()
    {
        $record = new Record([
            'name' => 'Antoine'
        ]);

        $record->set('age', 42);

        $this->assertEquals(
            42, $record->get('age')
        );
    }
}
