<?php

namespace Tests\Unit;

use Martin\ACL\User;
use Martin\Core\Image;
use Martin\Transactions\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ImagesUnitTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function an_image_has_a_model_factory() {
        $image = factory(Image::class)->create();
        $this->assertTrue($image instanceof Image);
    }

    /** @test */
    public function an_image_has_its_content_mass_assignable() {
        $imageData = factory(Image::class)
            ->make(['content' => 'invoice-00001']);

        Image::create($imageData->toArray());
        $this->assertDatabaseHas('images', $imageData->toArray());
    }

    /** @test */
    public function an_order_can_have_images_attached() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->images);
        $order->images()->save(factory(Image::class)->make());

        $order = $order->fresh(['images']);

        $this->assertCount(1, $order->images);
    }

    /** @test */
    public function an_image_can_get_the_item_it_is_attached_to() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->images);

        $order->images()->save(factory(Image::class)->make());

        $order = $order->fresh(['images.imageable']);
        $image = $order->images->first();

        $orderClone = $image->imageable;
        $this->assertTrue($orderClone instanceof Order);
        $this->assertEquals($order->id, $orderClone->id);
    }

    /** @test */
    public function an_image_belongs_to_a_user() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $this->assertCount(0, $order->images);

        $imageData = factory(Image::class)->make();
        $imageData['uploader_id']  = $this->user->id;
        $order->images()->save($imageData);

        $order = $order->fresh(['images.uploader']);
        $image = $order->images->first();

        $uploader = $image->uploader;
        $this->assertTrue($uploader instanceof User);
        $this->assertEquals($this->user->id, $uploader->id);
    }

    /** @test */
    public function an_image_knows_where_it_is_stored() {
        $this->loginAsAdmin();
        $order = factory(Order::class)->create();

        $order->images()->save(factory(Image::class)->make());

        $image = $order->images->first();
        $this->assertEquals('order', $image->type());
        $this->assertEquals('/images/order/'. $order->id . '-'. $image->id.'.'.$image->extension,
            $image->url());
    }
}
