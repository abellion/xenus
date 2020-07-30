<?php

namespace Xenus\Tests\Tests;

use MongoDB\BSON\ObjectID;

use Xenus\Tests\Stubs;
use Xenus\Document as XenusDocument;
use Xenus\Tests\Support\SetupEventsTest;

class EventsTest extends \PHPUnit\Framework\TestCase
{
    use SetupEventsTest;

    public function test_creating_event_is_dispatched_when_inserting()
    {
        $this->tokens->setEvent(
            'creating', Stubs\Events\DocumentCreating::class
        );

        $this->tokens->insert(
            new XenusDocument()
        );

        $this->assertContains(
            Stubs\Events\DocumentCreating::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_created_event_is_dispatched_when_inserting()
    {
        $this->tokens->setEvent(
            'created', Stubs\Events\DocumentCreated::class
        );

        $this->tokens->insert(
            new XenusDocument()
        );

        $this->assertContains(
            Stubs\Events\DocumentCreated::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_saving_event_is_dispatched_when_inserting()
    {
        $this->tokens->setEvent(
            'saving', Stubs\Events\DocumentSaving::class
        );

        $this->tokens->insert(
            new XenusDocument()
        );

        $this->assertContains(
            Stubs\Events\DocumentSaving::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_saved_event_is_dispatched_when_inserting()
    {
        $this->tokens->setEvent(
            'saved', Stubs\Events\DocumentSaved::class
        );

        $this->tokens->insert(
            new XenusDocument()
        );

        $this->assertContains(
            Stubs\Events\DocumentSaved::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_updating_event_is_dispatched_when_updating()
    {
        $this->tokens->setEvent(
            'updating', Stubs\Events\DocumentUpdating::class
        );

        $this->tokens->update(
            new XenusDocument(['_id' => new ObjectID()])
        );

        $this->assertContains(
            Stubs\Events\DocumentUpdating::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_updated_event_is_dispatched_when_updating()
    {
        $this->tokens->setEvent(
            'updated', Stubs\Events\DocumentUpdated::class
        );

        $this->tokens->update(
            new XenusDocument(['_id' => new ObjectID()])
        );

        $this->assertContains(
            Stubs\Events\DocumentUpdated::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_saving_event_is_dispatched_when_updating()
    {
        $this->tokens->setEvent(
            'saving', Stubs\Events\DocumentSaving::class
        );

        $this->tokens->update(
            new XenusDocument(['_id' => new ObjectID()])
        );

        $this->assertContains(
            Stubs\Events\DocumentSaving::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_saved_event_is_dispatched_when_updating()
    {
        $this->tokens->setEvent(
            'saved', Stubs\Events\DocumentSaved::class
        );

        $this->tokens->update(
            new XenusDocument(['_id' => new ObjectID()])
        );

        $this->assertContains(
            Stubs\Events\DocumentSaved::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_deleting_event_is_dispatched_when_deleting()
    {
        $this->tokens->setEvent(
            'deleting', Stubs\Events\DocumentDeleting::class
        );

        $this->tokens->delete(
            new XenusDocument(['_id' => new ObjectID()])
        );

        $this->assertContains(
            Stubs\Events\DocumentDeleting::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }

    public function test_deleted_event_is_dispatched_when_deleting()
    {
        $this->tokens->setEvent(
            'deleted', Stubs\Events\DocumentDeleted::class
        );

        $this->tokens->delete(
            new XenusDocument(['_id' => new ObjectID()])
        );

        $this->assertContains(
            Stubs\Events\DocumentDeleted::class, $this->dispatcher->dispatched
        );

        $this->assertCount(
            1, $this->dispatcher->dispatched
        );
    }
}
