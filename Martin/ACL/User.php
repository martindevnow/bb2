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

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param $id
     * @return mixed
     */
    public function getPetById($id) {
        return $this->pets()->where('id', $id)->firstOrFail();
    }

    /**
     * @param $name
     * @param $weight
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createNewPet($name, $weight) {
        return $this->pets()->create(compact("name", "weight"));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pets() {
        return $this->hasMany(Pet::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function plans() {
        return $this->hasMany(Plan::class);
    }
}
