<?php

namespace Tests\Unit;

use Martin\Transactions\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NotesUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_order_can_have_notes_attached() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->notes);

        $content = 'This order will be delayed.. call the customer.';
        $order->attachNote($content);

        $order = $order->fresh(['notes']);

        $this->assertCount(1, $order->notes);
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
}
