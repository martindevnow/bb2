<?php

namespace Martin\Delivery;

use Illuminate\Database\Eloquent\Model;

class PickupLocation extends Model
{
    protected $fillable = [
        'label',
        'street',
        'city',
        'province',
        'postal_code',
    ];




    /**
     * Relationships
     */

    public function pickupAppointments() {
        return $this->hasMany(PickupAppointment::class);
    }
}
