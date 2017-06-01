<?php

namespace Martin\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'size',
        'sku',
        'price'
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function toDollars() {
        return $this->price / 100;
    }
}
