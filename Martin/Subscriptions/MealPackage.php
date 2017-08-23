<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Products\Meal;

class MealPackage extends Model
{
    /**
     * The SQL Table to store this data
     *
     * @var string
     */
    protected $table = 'meal_package';

    /**
     * Fields which are "mass-assignable"
     *
     * @var array
     */
    protected $fillable = [
        'meal_id',
        'package_id',
        'calendar_code',
    ];
}
