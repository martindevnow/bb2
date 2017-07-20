<?php

namespace Martin\Products\Traits;

use Martin\Products\Meat;

trait HasMeats {

    /**
     * @param $meat
     * @return Model
     */
    public function addMeat($meat) {
        if (is_string($meat))
            return $this->meats()->save(
                Meat::whereCode($meat)->firstOrFail()
            );

        if ($meat instanceof Meat)
            return $this->meats()->save($meat);

        return $this->meats()->save(
            Meat::findOrFail($meat)
        );
    }

    /**
     * @param $meat
     * @return int
     */
    public function removeMeat($meat) {
        if (is_string($meat))
            return $this->meats()->detach(
                Meat::whereCode($meat)->firstOrFail()
            );

        $this->meats()->detach($meat);
    }

    /**
     * @param $meat
     * @return bool
     */
    public function hasMeat($meat) {
        if (is_string($meat))
            return $this->meats->contains('code', $meat);

        if ($meat instanceof Meat)
            return !! $this->meats()->whereCode($meat->code)->count();

        if (is_integer($meat))
            return !! $this->meats()->where('meat_id', $meat)->count();

        // TODO: Throw an error here...
        return false;
    }

}