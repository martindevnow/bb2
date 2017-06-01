<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Martin\ACL\User;
use Martin\Core\Traits\RecordsActivity;
use ReflectionClass;

class Image extends Model {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content',
        'height',
        'width',
        'path',
        'thumbnail'
    ];



    public function trash() {
        return $this->delete();
    }

    protected function getImageableType()
    {
        if ($this->type)
            return $this->type;

        return $this->type = strtolower((new ReflectionClass($this->imageable))->getShortName());
    }

    public function getUrlToImageable()
    {
        $model = $this->imageable;
        $type = $this->getImageableType();

        switch ($type) {
            case "payment":
                $type .= "s";
                break;
            default:
                break;
        }
        return "/admins/{$type}/{$model->id}";
    }

    /**
     * An Image can be added to Anything
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * Images are added by Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 