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
     * @param CartRepository $cartRepo
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
        $this->cartRepo->evaluateFees();
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

            flash('Item added.')->success();
            return redirect('/cart');
        }
    
        $this->cartRepo->addQuantity($product, 1);
        
        flash('Quantity updated')->success();        
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

        flash('Item removed.')->success();
        return redirect('/cart');
    }

    public function update(Request $request) {
         $products = $request->get('products');

         foreach ($products as $id => $quantity) {
             if ($this->cartRepo->has($id)) {
                $this->cartRepo->setQuantity($id, $quantity);
            }
        }
        flash('Cart updated')->success();        
        return redirect('/cart');
    }

    public function clear() {
        $this->cartRepo->clear();
        flash('Your cart is empty.');
        return redirect('/cart');
    }

}
