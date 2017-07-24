<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'label',
        'question',
        'answer',
        'faq_category_id'
    ];


    /**
     * Categories
     */

    /**
     * @param $category
     * @return bool|false|Model
     */
    public function assignCategory($category) {
        if ($category instanceof FaqCategory) {
            return $category->faqs()->save($this);
        }

        if (is_string($category))
            return FaqCategory::where('code', $category)
                ->firstOrFail()
                ->faqs()
                ->save($this);

        if (is_int($category)) {
            return FaqCategory::findOrFail($category)
                ->faqs()
                ->save($this);
        }

        return false;
    }


    /**
     * Relationships
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(FaqCategory::class, 'faq_category_id');
    }
}
