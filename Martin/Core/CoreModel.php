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
    public function notes()
    {
        return $this->morphMany(\Martin\Core\Note::class, 'noteable');
    }


    /**
     * Many models require an address
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function addresses()
    {
        return $this->morphMany(\Martin\Core\Address::class, 'addressable');
    }


    /**
     * Several models may have images associated
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function images()
    {
        return $this->morphMany(\Martin\Core\Image::class, 'imageable');
    }


    /**
     * Many of the core entities will have attachments
     *  - inbound PS, inbound BOL, inbound RR, Retailer BOL, Inv, Order, PS, etc
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(\Martin\Core\Attachment::class, 'attachmentable');
    }

    /**
     * Many of the core retailers/providers/clients will have Aliases
     *  - ie) PurEss, pures, PurEssentiel, 'PurEssentiel Inc.' .. etc, etc
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function aliases()
    {
        return $this->morphMany(\Martin\Core\Alias::class, 'aliasable');
    }

    /**
     * Many entities can be mentioned in various emails
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function receivedEmails()
    {
        return $this->morphToMany(ReceivedEmail::class, 'received_emailables');
    }
}