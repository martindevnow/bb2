<?php

namespace App\Http\Controllers;

use Martin\Products\Product;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Martin\Transactions\CartRepository;


class CartController extends Controller
{

    public $cartRepo;

    /**
     * Create a new controller instance.
     */
    public function __construct(CartRepository $cartRepo) {
        $this->cartRepo = $cartRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $cart = $this->cartRepo;

        return view('cart.index')
            ->with(compact('cart'));
    }

    /**
     * 
     */
    public function add($treat_id) {
        $product = Product::findOrFail($treat_id);

        if (! $this->cartRepo->has($product)) {
            $this->cartRepo->add($product, 1);

            Flash::message('Item added.');
            return redirect('/cart');
        }
    
        $this->cartRepo->addQuantity($product, 1);
        
        Flash::message('Quantity updated');        
        return redirect('/cart');
    }

    /**
     * 
     */
    public function remove($treat_id) {
        $product = Product::findOrFail($treat_id);

        if (! $this->cartRepo->has($product->id))
            return redirect('/cart');

        $this->cartRepo->remove($product);

        Flash::message('Item removed.');
        return redirect('/cart');
    }

    public function update(Request $request) {
         $products = $request->get('products');

         foreach ($products as $id => $quantity) {
             if ($this->cartRepo->has($id)) {
                $this->cartRepo->setQuantity($id, $quantity);
            }
        }
        Flash::message('Cart updated');        
        return redirect('/cart');
    }

    public function clear() {
        return $this->cartRepo->clear();
    }

    private function cartHas($product_id) {
        return !! \Cart::getContent()->filter(function($item) use ($product_id) {
            return $product_id === $item->id;
        })->count();
    }

    private function cartRow($product_id) {
        if (! $this->cartHas($product_id))
            return null;

        return \Cart::getContent()->filter(function($item) use ($product_id) {
            return $product_id === $item->id;
        })->first();
    }

}
