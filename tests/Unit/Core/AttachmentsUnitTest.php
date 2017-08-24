<?php

namespace Tests\Unit;

use Martin\ACL\User;
use Martin\Core\Attachment;
use Martin\Transactions\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AttachmentsUnitTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_attachment_has_a_model_factory() {
        $attachment = factory(Attachment::class)->create();
        $this->assertTrue($attachment instanceof Attachment);
    }

    /** @test */
    public function an_attachment_has_its_content_mass_assignable() {
        $attachmentData = factory(Attachment::class)
            ->make(['original_filename' => 'invoice-00001']);

        Attachment::create($attachmentData->toArray());
        $this->assertDatabaseHas('attachments', $attachmentData->toArray());
    }

    /** @test */
    public function an_order_can_have_attachments_attached() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->attachments);
        $order->attachments()->save(factory(Attachment::class)->make());

        $order = $order->fresh(['attachments']);

        $this->assertCount(1, $order->attachments);
    }

    /** @test */
    public function an_attachment_can_get_the_item_it_is_attached_to() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->attachments);

        $order->attachments()->save(factory(Attachment::class)->make());

        $order = $order->fresh(['attachments.attachmentable']);
        $attachment = $order->attachments->first();

        $orderClone = $attachment->attachmentable;
        $this->assertTrue($orderClone instanceof Order);
        $this->assertEquals($order->id, $orderClone->id);
    }

    /** @test */
    public function an_attachment_has_an_uploader() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->attachments);

        $attachmentData = factory(Attachment::class)->make();
        $attachmentData['uploader_id']  = $this->user->id;
        $order->attachments()->save($attachmentData);

        $order = $order->fresh(['attachments.uploader']);
        $attachment = $order->attachments->first();

        $uploader = $attachment->uploader;
        $this->assertTrue($uploader instanceof User);
        $this->assertEquals($this->user->id, $uploader->id);
    }
}
