<?php

namespace Tests\Unit\Subscriptions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Products\Product;
use Tests\TestCase;


class PlanProductUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_plan_can_have_products_associated() {
        $this->buildPlan();

        $product = factory(Product::class)->create();
        $this->plan->addProduct($product);

        $this->assertCount(1, $this->plan->products);
    }

    /** @test */
    public function a_plan_can_query_if_a_product_is_associated() {
        $this->buildPlan();

        $product = factory(Product::class)->create();
        $this->plan->addProduct($product);

        $this->assertTrue($this->plan->hasProduct($product));
    }

    /** @test */
    public function a_plan_can_have_products_removed() {
        $this->buildPlan();

        $product = factory(Product::class)->create();
        $this->plan->addProduct($product);

        $this->assertCount(1, $this->plan->products);

        $this->plan->removeProduct($product);

        $this->plan = $this->plan->fresh(['products']);
        $this->assertCount(0, $this->plan->products);
    }

    /** @test */
    public function an_order_generated_from_a_plan_with_products_has_these_details() {
        $this->buildPlan();

        $product = factory(Product::class)->create();
        $this->plan->addProduct($product);

        $this->buildOrder();

        $this->assertCount(1, $this->order[0]->details);
    }
}
