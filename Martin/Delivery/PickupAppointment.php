<?php

namespace Martin\Delivery;

use Illuminate\Database\Eloquent\Model;

class PickupAppointment extends Model
{
    protected $fillable = [
        'day_of_the_week',
        'time_of_day',
        'pickup_location_id',
        'active',
    ];


    /**
     * Relationships
     */

    public function pickupLocation() {
        return $this->belongsTo(PickupLocation::class);
    }
}
