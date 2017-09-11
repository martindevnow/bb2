<?php

namespace Martin\Transactions;

use Illuminate\Database\Eloquent\Model;
use Martin\Subscriptions\Package;

class ShoppingCart extends Model
{
    /**
     * Any field is mass-assignable
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Create a new cart with a fresh hash
     *
     * @param $weight
     * @param $package_id
     * @param $shipping
     * @return mixed
     */
    public static function build($weight, $package_id, $shipping) {
        $hash = str_random(16);
        return (new static)::create([
            'hash'          => $hash,
            'sub_weight'    => $weight,
            'sub_package_id' => $package_id,
            'sub_shipping_modifier' => $shipping,
        ]);
    }

    /**
     * Retrieve a cart by its hash
     *
     * @param $hash
     * @return Model|static
     */
    public static function byHash($hash) {
        return ShoppingCart::with('subPackage')
            ->where('hash', $hash)
            ->orderBy('updated_at', 'desc')
            ->firstOrFail();
    }

    public function subPackage() {
        return $this->belongsTo(Package::class, 'sub_package_id');
    }
}
