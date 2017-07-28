<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'label',
        'quantity',
        'unit_cost',
        'extended_cost',
        'tax',
    ];
}
