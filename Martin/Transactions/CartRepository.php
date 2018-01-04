<?php

namespace Martin\Transactions;

class CartRepository {

    public function __construct() {
        if (! \Cart::getCondition('HST 13%')) {
            $taxCondition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'HST 13%',
                'type' => 'tax',
                'target' => 'subtotal',
                'value' => '13%',
                'order' => 10,
            ));

            \Cart::condition($taxCondition);
        }

        if (\Cart::getSubTotal() < 50) {
            $shippingCondition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Shipping (Canada)',
                'type' => 'shipping',
                'target' => 'subtotal',
                'value' => '+5.95',
                'order' => 1,
            ));

            \Cart::condition($shippingCondition);
        } else {
            \Cart::removeCartCondition('Shipping (Canada)');
        }
    }

    public function getSubTotal() {
        return \Cart::getSubTotal();
    }

    public function getTotal() {
        return \Cart::getTotal();
    }

    public function getConditions() {
        return \Cart::getConditions();
    }

    public function getCondition($conditionName) {
        return \Cart::getCondition($conditionName);
    }

    public function getContent() {
        return \Cart::getContent();
    }

    public function add($model, $quantity) {
        return \Cart::add([
            'id'        => $model->id,
            'name'      => $model->name,
            'price'     => $model->price,
            'quantity'      => $quantity,
            'attributes'    => $model->toArray(),
        ]);
    }

    public function has($model) {
        if (is_int($model))
            $id = $model;
        else
            $id = $model->id;

        return !! \Cart::get($id);
    }

    public function addQuantity($model, $quantity) {
        return \Cart::update($model->id, [
            'quantity'  => $quantity,
        ]);
    }

    public function setQuantity($model, $quantity) {
        if (is_int($model)) {
            $id = $model;
        } else {
            $id = $model->id;
        }

        return \Cart::update($id, [
            'quantity' => [
                'relative'  => false,
                'value' => $quantity,
            ],
        ]);
    }

    public function remove($model){
        return \Cart::remove($model->id);
    }

    public function clear() {
        \Cart::clear();
    }


}