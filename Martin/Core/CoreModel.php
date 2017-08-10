<?php

namespace Martin\Core;

use Illuminate\Database\Eloquent\Model;
use Martin\Mail\ReceivedEmail;

class CoreModel extends Model {

    /**
     * A CoreModel may have many notes associated
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notes() {
        return $this->morphMany(\Martin\Core\Note::class, 'noteable');
    }

    /**
     * Easy method to save a note to a child of 'CoreModel'
     *
     * @param $content
     * @return Model
     */
    public function attachNote($content) {
        $author_id = auth()->user()->id;
        return $this->notes()->create(compact('content', 'author_id'));
    }


    /**
     * Many models require an address
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses() {
        return $this->morphMany(\Martin\Core\Address::class, 'addressable');
    }


    /**
     * Several models may have images associated
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images() {
        return $this->morphMany(\Martin\Core\Image::class, 'imageable');
    }


    /**
     * Many of the core entities will have attachments
     *  - inbound PS, inbound BOL, inbound RR, Retailer BOL, Inv, Order, PS, etc
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments() {
        return $this->morphMany(\Martin\Core\Attachment::class, 'attachmentable');
    }
}