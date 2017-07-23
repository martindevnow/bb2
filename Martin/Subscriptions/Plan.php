<?php

namespace Martin\Subscriptions;

use App\Http\Controllers\PackagesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'stripe_plan_name',
        'package_id',
        'frequency_id',
        'active',
    ];



    /**
     * Mutators
     */


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subPackage() {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
