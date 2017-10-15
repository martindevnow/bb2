<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Martin\Products\Inventory;
use Martin\Products\Meat;
use Martin\Transactions\Order;
use Tests\TestCase;

class InventoriesUnitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_model_factory() {
        $inventory = factory(Inventory::class)->create();
        $this->assertTrue($inventory instanceof Inventory);
    }

    /** @test */
    public function it_has_most_fields_mass_assignable() {
        $order = factory(Order::class)->create();
        $meat = factory(Meat::class)->create();

        $inventoryData = [
            'inventoryable_type' => get_class($meat),
            'inventoryable_id' => $meat->id,
            'size' => 0,
            'change' => -14,
            'changeable_type' => get_class($order),
            'changeable_id' => $order->id,
            'current' => 150,
        ];
        $inventory = factory(Inventory::class)->create($inventoryData);
        $inventoryData['change'] *= 100;
        $inventoryData['current'] *= 100;
        $this->assertDatabaseHas('inventories', $inventoryData);

        $inventory = $inventory->fresh(['changeable', 'inventoryable']);

        $this->assertEquals(-14, $inventory->change);
        $this->assertEquals(150, $inventory->current);

        $changeable = $inventory->changeable;
        $inventoryable = $inventory->inventoryable;

        $this->assertTrue($changeable instanceof Order);
        $this->assertTrue($inventoryable instanceof Meat);

        $this->assertEquals($order->id, $changeable->id);
        $this->assertEquals($meat->id, $inventoryable->id);

    }
}
