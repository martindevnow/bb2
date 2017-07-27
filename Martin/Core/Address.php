<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ReflectionClass;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'active',
        'name',
        'description',
        'company',

        'street_1', 	// string
        'street_2', 	// string
        'city', 	    // string
        'province',     // string
        'postal_code',  // string
        'country',      // string

        'phone', 	    // string
        'buzzer',

        'addressable_id',
        'addressable_type',
    ];

    protected $type;

    /**
     * Return the Type of Address
     *
     * @return string
     */
    protected function getAddressableType()
    {
        if ($this->type)
            return $this->type;

        return $this->type = strtolower((new ReflectionClass($this->addressable))
            ->getShortName());
    }

    /**
     * Get the URL for the associated Entity
     *
     * @return string
     */
    public function getUrlToAddressable()
    {
        return "/admin/{$this->getAddressableType()}/{$this->addressable_id}";
    }

    /**
     * An Address can be attached to Any Entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}
