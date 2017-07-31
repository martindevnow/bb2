<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Filesystem\Filesystem;
use Martin\ACL\User;

class Attachment extends Model
{
    use SoftDeletes;

    /**
     * Mass-assignable Fields
     *
     * @var array
     */
    public $fillable = [
        'user_id',
        'original_file_name',
        'file_name',
        'file_path',
        'file_extension',
        'description',
        'type',
        'attachmentable_id',
        'attachmentable_type',
    ];

    /**
     * Fields to format as Carbon
     *
     * @var array
     */
    public $dates = [];

    public function createEntity($type, $attributes) {
        $model = new $type($attributes);
        $model->save();
        $model->saveEmail($this->attachmentable);
    }

    /**
     * StoragePath
     *
     * @return string
     */
    public function getStoragePathAttribute() {
        return '/email/attachments/';
    }

    /**
     * Returns a download response to the file location
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download() {
        return response()->download(base_path() . '/' . $this->file_path . '/' . $this->filename(), $this->filename());
    }

//    /**
//     * Save the file locally
//     *
//     * @param \PhpMimeMailParser\Attachment $emailAttachment
//     */
//    public function saveFile(\PhpMimeMailParser\Attachment $emailAttachment)
//    {
//        $filesystem = new Filesystem();
//        $filesystem->put(base_path() . $this->file_path .'/' . $this->filename(),
//            $emailAttachment->getContent()
//        );
//    }

    /**
     * Return the filename of this Attachment
     *
     * @return string
     */
    public function filename() {
        if ($this->file_name == "")
            return 'email-'. $this->attachmentable->id . '_attachment-' . $this->id . '.' . $this->file_extension;

        return $this->file_name . '.' . $this->file_extension;
    }

    /**
     * This can be an attachment to anything
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachmentable() {
        return $this->morphTo();
    }

    /**
     * Attachments can only be uploaded by admins
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
