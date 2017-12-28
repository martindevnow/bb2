<?php

namespace App\Http\Controllers;

use Martin\Products\Product;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct() {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $cart = \Cart::content();

        return view('cart.index')
            ->with(compact('cart'));
    }

    /**
     * 
     */
    public function add($treat_id) {
        $product = Product::findOrFail($treat_id);

        if (! $this->cartHas($product->id)) {
            \Cart::add($product, 1);

            Flash::message('Item added.');
            return redirect('/cart');
        }
    
        $row = $this->cartRow($product->id);
        \Cart::update($row->rowId, ['qty' => ++$row->qty]);
        Flash::message('Quantity updated');        
        return redirect('/cart');
    }

    /**
     * 
     */
    public function remove($treat_id) {
        $product = Product::findOrFail($treat_id);

        if (! $this->cartHas($product->id))
            return redirect('/cart');
        $row = $this->cartRow($product->id);

        \Cart::remove($row->rowId);

        Flash::message('Item removed.');
        return redirect('/cart');
    }

    public function update(Request $request) {
         $products = $request->get('products');

         foreach ($products as $id => $qty) {
             if ($this->cartHas($id)) {
                $row = $this->cartRow($id);
                \Cart::update($row->rowId, ['qty' => $qty]);
            }
        }
        Flash::message('Cart updated');        
        return redirect('/cart');
    }

    private function cartHas($product_id) {
        return !! \Cart::content()->filter(function($item) use ($product_id) {
            return $product_id === $item->id;
        })->count();
    }

    private function cartRow($product_id) {
        if (! $this->cartHas($product_id))
            return null;

        return \Cart::content()->filter(function($item) use ($product_id) {
            return $product_id === $item->id;
        })->first();
    }

}
