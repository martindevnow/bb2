<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\DB;
use Martin\Core\Image;
use Martin\Products\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsUnitTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function products_have_a_model_factory() {
        $product = factory(Product::class)->create();
        $this->assertTrue($product instanceof Product);
    }

    /** @test */
    public function products_have_most_fields_mass_assignable() {
        $productData = [
            'name'  => 'Beef Lung',
            'description'   => 'A bag of dehydrated beef lung',
            'description_long'  => 'this is long',
            'size'  => '50g',
            'sku'   => 'BE_LUNG',
            'ingredients'   => 'dehydrated beef lung',
            'price' => 5.00,
        ];
        $product = factory(Product::class)->create($productData);

        $productData['price'] *= 100;

        $this->assertDatabaseHas('products', $productData);
    }

    /**
     * Mutators
     */

    /** @test */
    public function price_is_mutated_when_saving() {
        $priceInDollars = 1;
        $priceInCents = $priceInDollars * 100;

        factory(Product::class)->create(['price' => $priceInDollars]);
        $this->assertDatabaseHas('products', ['price' => $priceInCents]);
    }

    /** @test */
    public function price_is_mutated_when_retrieving() {
        $priceInDollars = 1;
        $priceInCents = $priceInDollars * 100;

        $product = factory(Product::class)->make([
            'name'=> 'THISMEAT',
            'price' => $priceInCents
        ]);
        DB::table('products')->insert($product->toArray());
        $product_clone = Product::where('name', 'THISMEAT')->firstOrFail();
        $this->assertEquals($priceInDollars, $product_clone->price);
    }

    /** @test */
    public function a_product_can_have_many_images_attached_to_it() {
        $product = factory(Product::class)->create();
        $product->images()->save(factory(Image::class)->make());

        $this->assertCount(1, $product->images);
    }
}
