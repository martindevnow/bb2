<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\Core\Traits\RecordsActivity;

class Note extends Model
{
    use SoftDeletes;

    use RecordsActivity;

    protected static $recordEvents = ['created'];

    protected $fillable = [
        'user_id',
        'content',
        'noteable_id',
        'noteable_type'
    ];

    /**
     * A Note can be attached to Anything
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function noteable() {
        return $this->morphTo();
    }

    /**
     * A Note is created by a User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('Martin\Users\User');
    }
}
