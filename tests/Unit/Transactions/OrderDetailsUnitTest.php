<?php

namespace Tests\Unit\Transactions;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Martin\ACL\User;
use Martin\Core\Address;
use Martin\Core\Attachment;
use Martin\Delivery\Courier;
use Martin\Delivery\Delivery;
use Martin\Products\Meal;
use Martin\Products\Meat;
use Martin\Products\Product;
use Martin\Subscriptions\Package;
use Martin\Subscriptions\Plan;
use Martin\Transactions\Order;
use Martin\Transactions\Payment;
use Tests\TestCase;

class OrderDetailsUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_order_can_have_details_associated() {
        $this->buildOrder();

        $product = factory(Product::class)->create();
        $this->order[0]->addProduct($product);

        $this->assertTrue($this->order[0]->hasProduct($product));
    }

    /** @test */
    public function an_order_can_have_details_added() {
        $this->buildOrder();

        $product = factory(Product::class)->create();
        $this->order[0]->addProduct($product);

        $this->assertCount(1, $this->order[0]->details);
    }

    /** @test */
    public function an_order_can_have_details_removed() {
        $this->buildOrder();

        $product = factory(Product::class)->create();
        $this->order[0]->addProduct($product);

        $this->assertCount(1, $this->order[0]->details);

        $this->order[0]->removeProduct($product);

        $this->refreshOrder(0);
        $this->assertCount(0, $this->order[0]->details);
    }

}
