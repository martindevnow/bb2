<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Vendors\PurchaseOrder;
use Martin\Vendors\Vendor;
use Tests\TestCase;

class VendorsUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_vendor_has_a_model_factory() {
        $vendor = factory(Vendor::class)->create();
        $this->assertTrue(true);
    }

    /** @test */
    public function a_vendor_has_its_fields_mass_assignable() {
        $vendorData = [
            'label' => 'Some Store',
            'code'  => 'some-store'
        ];

        factory(Vendor::class)->create($vendorData);
        $this->assertDatabaseHas('vendors', $vendorData);
    }

    /** @test */
    public function a_vendor_can_retrieve_the_purchase_orders_associated_to_it() {
        $vendor = factory(Vendor::class)->create();

        $po = factory(PurchaseOrder::class)->create([
            'vendor_id' => $vendor->id,
        ]);

        $vendor = $vendor->fresh(['purchaseOrders']);
        $this->assertCount(1, $vendor->purchaseOrders);
    }
}
