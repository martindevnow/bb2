<?php

namespace Tests\Unit;

use Martin\ACL\User;
use Martin\Core\Note;
use Martin\Transactions\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotesUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_note_has_a_model_factory() {
        $note = factory(Note::class)->create();
        $this->assertTrue($note instanceof Note);
    }

    /** @test */
    public function a_note_has_its_content_mass_assignable() {
        $noteData = factory(Note::class)
            ->make(['content' => 'This is the body of the note']);

        $note = Note::create($noteData->toArray());
        $this->assertDatabaseHas('notes', $noteData->toArray());
    }

    /** @test */
    public function an_order_can_have_notes_attached() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->notes);

        $content = 'This order will be delayed.. call the customer.';
        $order->attachNote($content);

        $order = $order->fresh(['notes']);

        $this->assertCount(1, $order->notes);
        $this->assertEquals($this->user->id, $order->notes->first()->author_id);
        $this->assertEquals($content, $order->notes->first()->content);
    }

    /** @test */
    public function a_note_can_get_the_item_it_is_attached_to() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->notes);

        $content = 'This order will be delayed.. call the customer.';
        $order->attachNote($content);

        $order = $order->fresh(['notes.noteable']);
        $note = $order->notes->first();

        $orderClone = $note->noteable;
        $this->assertTrue($orderClone instanceof Order);
        $this->assertEquals($order->id, $orderClone->id);
    }

    /** @test */
    public function a_note_has_an_author() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->notes);

        $content = 'This order will be delayed.. call the customer.';
        $order->attachNote($content);

        $order = $order->fresh(['notes.noteable']);
        $note = $order->notes->first();

        $author = $note->author;
        $this->assertTrue($author instanceof User);
        $this->assertEquals($order->author_id, $author->id);
    }
}
