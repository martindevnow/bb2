<?php

namespace Martin\ACL;

//use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Martin\ACL\Traits\HasRoles;
use Martin\Core\Activity;
use Martin\Customers\Pet;
use Martin\Products\Subscription;

class User extends Authenticatable
{
    use HasRoles;
    use SoftDeletes;
//    use HasApiTokens;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * User isn't active or inactive.
     * Only their subscriptions are..
     * because a user can have more than 1...
     * each PET can have a subscription
     */
    public function activate($customerId) {
        return $this->update([
            'stripe_customer_id'    => $customerId,
//            'stripe_active'         => true,
        ]);
    }
//    public function deactivate(Subscription $subscription) {
//        $this->update([
//            'stripe_active'         => false,
//            'subscription_ends_at'  => Carbon::now(),
//        ]);
//    }

    /**
     * A User hasMany Activities tracked by the system
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities() {
        return $this->hasMany(Activity::class);
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
    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
}
