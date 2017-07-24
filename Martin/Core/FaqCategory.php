<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'label'
    ];

    /**
     * FAQs
     */

    /**
     * Add an FAQ to this category by Model, Code or ID
     *
     * @param $faq
     * @return bool|false|Model
     */
    public function addFaq($faq) {
        if ($faq instanceof Faq)
            return $this->faqs()->save($faq);

        if (is_string($faq))
            return $this->faqs()->save(
                Faq::where('code', $faq)->firstOrFail()
            );

        if (is_int($faq))
            return $this->faqs()->save(
                Faq::findOrFail($faq)
            );

        return false;
    }


    /**
     * Relationships
     */

    /**
     * There are many FAQs in a Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function faqs() {
        return $this->hasMany(Faq::class);
    }
}
