<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Martin\Core\Image;
use Martin\Products\Meat;
use Martin\Vendors\PurchaseOrder;
use Martin\Vendors\PurchaseOrderDetail;
use Martin\Vendors\Vendor;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PurchaseOrdersUnitTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function purchase_orders_have_a_model_factory() {
        $purchase_order = factory(PurchaseOrder::class)->create();
        $this->assertTrue($purchase_order instanceof PurchaseOrder);
    }

    /** @test */
    public function purchase_orders_have_most_fields_mass_assignable() {
        $purchase_orderData = [
            'received_at'   => null,
            'received'  => false,
            'ordered_at'          => null,
            'ordered'           => false,
            'vendor_id'   => 1,
            'total'         => 5.00,
        ];
        $purchase_order = factory(PurchaseOrder::class)->create($purchase_orderData);
        $purchase_orderData['total'] *= 100;

        $this->assertDatabaseHas('purchase_orders', $purchase_orderData);
    }

    /**
     * Mutators
     */

    /** @test */
    public function total_is_mutated_when_saving() {
        $totalInDollars = 1;
        $totalInCents = $totalInDollars * 100;

        factory(PurchaseOrder::class)->create(['total' => $totalInDollars]);
        $this->assertDatabaseHas('purchase_orders', ['total' => $totalInCents]);
    }

    /** @test */
    public function total_is_mutated_when_retrieving() {
        $totalInDollars = 1;
        $totalInCents = $totalInDollars * 100;

        $purchase_order = factory(PurchaseOrder::class)->make([
            'vendor_id'=> 99999,
            'total' => $totalInCents
        ]);
        DB::table('purchase_orders')->insert($purchase_order->toArray());
        $purchase_order_clone = PurchaseOrder::where('vendor_id', 99999)->firstOrFail();
        $this->assertEquals($totalInDollars, $purchase_order_clone->total);
    }

    /** @test */
    public function a_purchase_order_can_have_many_images_attached_to_it() {
        $purchase_order = factory(PurchaseOrder::class)->create();
        $purchase_order->images()->save(factory(Image::class)->make());

        $this->assertCount(1, $purchase_order->images);
    }

    /** @test */
    public function a_purchase_order_belongs_to_one_vendor() {
        $purchaseOrder = factory(PurchaseOrder::class)->create();
        $vendor = $purchaseOrder->vendor;

        $this->assertTrue($vendor instanceof Vendor);
    }

    /** @test */
    public function a_purchase_order_has_many_details_to_it() {
        $po = factory(PurchaseOrder::class)->create();
        $details = factory(PurchaseOrderDetail::class, 4)->make();

        foreach ($details as $item) {
            $po->details()->save($item);
        }

        $po = $po->fresh(['details']);
        $this->assertCount(4, $po->details);
    }

    /** @test */
    public function a_purchase_order_can_have_details_added_to_it() {
        $po = factory(PurchaseOrder::class)->create();
        $po->addItem(factory(Meat::class)->create(), 5);

        $po = $po->fresh(['details']);
        $this->assertCount(1, $po->details);

        $detail = $po->details()->first();
        $this->assertTrue($detail instanceof PurchaseOrderDetail);
        $this->assertTrue($detail->purchasable instanceof Meat);
        $this->assertEquals(5, $detail->quantity);
    }

    /** @test */
    public function a_po_can_have_details_removed() {
        $po = factory(PurchaseOrder::class)->create();

        $po->addItem(factory(Meat::class)->create(), 10);
        $detail = $po->details()->first();

        $po->removeDetail($detail);
        $po = $po->fresh(['details']);

        $this->assertCount(0, $po->details);
    }

    /** @test */
    public function a_po_detail_can_have_its_quantity_updated() {
        $po = factory(PurchaseOrder::class)->create();

        $po->addItem(factory(Meat::class)->create(), 10);
        $detail = $po->details()->first();

        $detail->updateQuantity(50);
        $detail = $detail->fresh();

        $this->assertEquals(50, $detail->quantity);
    }
}
