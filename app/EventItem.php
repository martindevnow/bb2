<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventItem extends Model
{
    protected $guarded = [];

    public function getSpeakerNameAttribute($value) {
        return explode('<br>', $value);
    }
    public function getSpeakerLinkAttribute($value) {
        return explode('<br>', $value);
    }
    public function getSpeakerImgAttribute($value) {
        return explode('<br>', $value);
    }
    public function getSpeakerDescriptionAttribute($value) {
        return explode('<br>', $value);
    }
    public function getTime12hAttribute($value) {
        return explode(':', $value);
    }



    public function hasASpeaker() {
        return !! $this->speaker_name[0];
    }

    public function getSpeakerName($index) {
        if (isset($this->speaker_name[$index]))
            return $this->speaker_name[$index];
        return $this->speaker_name[0];
    }
    public function getSpeakerLink($index) {
        if (isset($this->speaker_link[$index]))
            return $this->speaker_link[$index];
        return $this->speaker_link[0];
    }
    public function getSpeakerDescription($index) {
        if (isset($this->speaker_description[$index]))
            return $this->speaker_description[$index];
        return $this->speaker_description[0];
    }
    public function getSpeakerImg($index) {
        if (isset($this->speaker_img[$index]))
            return '/wp-content/uploads'. $this->speaker_img[$index];
        return '/wp-content/uploads'. $this->speaker_img[0];
    }

    public function hasSpeakerImg($index = 0) {
        return isset($this->speaker_img[$index]) &&
            ! in_array($this->speaker_img[$index], [
                '',
                'Awaiting',
                'Need Headshots still'
            ]);
    }

    public function titleSlug() {
        return str_slug($this->title .' '. $this->id);
    }

    public function titleSpeakerSlug($key) {
        return str_slug($this->title . ' ' . $this->getSpeakerName($key));
    }

}
