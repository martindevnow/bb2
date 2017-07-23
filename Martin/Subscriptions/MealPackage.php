<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Products\Meal;

class MealPackage extends Model
{
    protected $table = 'meal_package';

    protected $fillable = [
        'meal_id',
        'package_id',
        'calendar_code',
    ];

    /**
     * Relationships
     */

    public function meal() {
        return $this->belongsTo(Meal::class);
    }

    public function package() {
        return $this->belongsTo(Package::class);
    }
}
