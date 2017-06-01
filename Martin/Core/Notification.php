<?php namespace Martin\Core;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use ReflectionClass;

class Notification extends Model {

    /**
     * This class is used to raise notifications when something happens on the site
     * that is NOT done by a User.
     *
     * These will primarily be actions taken my the automated systems.
     * If something needs to be notified to someone, we can raise a notification
     */

    public $fillable = [
        'action',
        'notificationable_id',
        'notificationable_type',
        'seen',
        'seen_by',
        'seen_at',
    ];

    /**
     * Attribute:   type
     *
     * @return string
     */
    public function getTypeAttribute()
    {
        return (new ReflectionClass($this->notificationable))->getShortName();
    }

    /**
     * Mark $this Notification as 'seen'
     */
    public function see()
    {
        $this->seen = true;
        $this->seen_by = \Auth::user()->id;
        $this->seen_at = Carbon::now();
        $this->save();
    }

    /**
     * Scopes to view only unseen notifications
     *
     * @param $query
     * @return mixed
     */
    public function scopeUnseen($query)
    {
        return $query->where('seen', '=', false);
    }

    /**
     * The User who saw this Notification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function viewer()
    {
        return $this->belongsTo(User::class, 'seen_by');
    }

    /**
     * A Notification can be raised by Many Entities
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notificationable()
    {
        return $this->morphTo();
    }
}
