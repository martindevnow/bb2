<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Martin\Products\Product;

class ProductsController extends Controller {

    /**
     * Fetch a list of Products
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection|static[] |Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return Product::all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request) {
        $validData = $request->validate([
            'name'              => 'required',
            'description'       => 'required',
            'description_long'  => 'nullable',
            'size'              => 'required',
            'sku'               => 'required',
            'ingredients'       => 'required',
            'price'             => 'required|numeric',
        ]);

        $product = Product::create($validData);

        return $product;
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return mixed
     */
    public function update(Product $product, Request $request) {
        $validData = $request->validate([
            'name'              => 'required',
            'description'       => 'required',
            'description_long'  => 'nullable',
            'size'              => 'required',
            'sku'               => 'required',
            'ingredients'       => 'required',
            'price'             => 'required|numeric',
        ]);

        $product->update($validData);

        return $product;
    }

}