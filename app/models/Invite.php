<?php

class Invite extends Eloquent {

  public static function boot()
  {
    parent::boot();

    static::creating(function($invite) {
      $invite->code = str_random(8);
    });
  }

  public function account()
  {
    return $this->belongsTo('Account');
  }

}
