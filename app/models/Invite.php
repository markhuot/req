<?php

class Invite extends Eloquent {

  public static function boot()
  {
    parent::boot();

    static::creating(function($invite) {
      $invite->code = '8adsyf7gab';
    });
  }

  public function account()
  {
    return $this->belongsTo('Account');
  }

}
