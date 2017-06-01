<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Martin\ACL\User;

class Activity extends Model
{
    public $fillable = [
        'user_id',
        'ip_address',
        'name',
        'subject_id',
        'subject_type',
    ];

    public $dates = [

    ];

    /**
     * Save $this Activity to a User
     *
     * @param User $user
     */
    public function saveToUser(User $user)
    {
        $user->activities()->save($this);
    }

    /**
     * Each Activity belongsTo a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
