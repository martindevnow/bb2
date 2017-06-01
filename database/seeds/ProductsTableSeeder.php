<?php

use Illuminate\Database\Seeder;
use Martin\Products\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Meat
         */
        Product::create([
            'name'          => 'Dehydrated Pork Liver',
            'description'   => 'Bag of dehydrated pork liver',
            'size'          => '60g',
            'sku'           => 'DH-PORKLIVER-60G',
            'price'         => 500,
        ]);

        Product::create([
            'name'          => 'Chicken Feet',
            'description'   => 'Bag of dehydrated chicken feet',
            'size'          => '8pc',
            'sku'           => 'DH-CHICKFT-8PC',
            'price'         => 500,
        ]);

        Product::create([
            'name'          => 'Pig Ear',
            'description'   => 'Dehydrated pig ear treat (Small)',
            'size'          => 'small',
            'sku'           => 'DH-PIGEAR-SM',
            'price'         => 300,
        ]);

        Product::create([
            'name'          => 'Pig Ear',
            'description'   => 'Dehydrated pig ear treat (Large)',
            'size'          => 'large',
            'sku'           => 'DH-PIGEAR-LG',
            'price'         => 400,
        ]);


        /**
         * Veggies
         */
        Product::create([
            'name'          => 'Dehydrated Apple',
            'description'   => 'Bag of dehydrated apple chips',
            'size'          => '30g',
            'sku'           => 'DH-APPLE-30G',
            'price'         => 300,
        ]);

        Product::create([
            'name'          => 'Dehydrated Carrot',
            'description'   => 'Bag of dehydrated carrot chips',
            'size'          => 'XXg',
            'sku'           => 'DH-CARROT-40G',
            'price'         => 300,
        ]);

        Product::create([
            'name'          => 'Dehydrated Yam',
            'description'   => 'Bag of dehydrated yam treats',
            'size'          => '40g',
            'sku'           => 'DH-YAMYL-40G',
            'price'         => 300,
        ]);

        Product::create([
            'name'          => 'Dehydrated Yam',
            'description'   => 'Bag of dehydrated purple yam',
            'size'          => '40g',
            'sku'           => 'DH-YAMPURP-40G',
            'price'         => 400,
        ]);

        Product::create([
            'name'          => 'Dehydrated Sweet Potato',
            'description'   => 'Bag of dehydrated sweet potato',
            'size'          => '40g',
            'sku'           => 'DH-SWPOTATO-40G',
            'price'         => 300,
        ]);
    }
}
