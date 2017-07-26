<?php

namespace Martin\ACL;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Martin\ACL\Traits\HasRoles;
use Martin\Customers\Pet;
use Martin\Subscriptions\Plan;

class User extends Authenticatable
{
    use HasRoles;
    use SoftDeletes;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $guarded = [
        'stripe_customer_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param $id
     * @return mixed
     */
    public function getPetById($id) {
        return $this->pets()->where('id', $id)->firstOrFail();
    }

    /**
     * Return a simple list of the pets
     *
     * @return string
     */
    public function getPets() {
        if (! $this->pets()->count())
            return '';

        $result = '';
        foreach($this->pets as $pet) {
            $result .= $pet->name . ', ';
        }

        return substr($result, 0, -2);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pets() {
        return $this->hasMany(Pet::class, 'owner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans() {
        return $this->hasMany(Plan::class);
    }
}
