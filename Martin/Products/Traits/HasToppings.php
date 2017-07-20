<?php

namespace Martin\Products\Traits;

use Martin\Products\Topping;

trait HasToppings {

    /**
     * @param $topping
     * @return Model
     */
    public function addTopping($topping) {
        if (is_string($topping))
            return $this->toppings()->save(
                Topping::whereCode($topping)->firstOrFail()
            );

        if ($topping instanceof Topping)
            return $this->toppings()->save($topping);

        return $this->toppings()->save(
            Topping::findOrFail($topping)
        );
    }

    /**
     * @param $topping
     * @return int
     */
    public function removeTopping($topping) {
        if (is_string($topping))
            return $this->toppings()->detach(
                Topping::whereCode($topping)->firstOrFail()
            );

        $this->toppings()->detach($topping);
    }

    /**
     * @param $topping
     * @return bool
     */
    public function hasTopping($topping) {
        if (is_string($topping))
            return $this->toppings->contains('code', $topping);

        if ($topping instanceof Topping)
            return !! $this->toppings()->whereCode($topping->code)->count();

        if (is_integer($topping))
            return !! $this->toppings()->where('topping_id', $topping)->count();

        // TODO: Throw an error here...
        return false;
    }

}