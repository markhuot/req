<?php

class Notification extends Eloquent {

  protected $fillable = [
    'notes',
  ];

  public function user()
  {
    return $this->belongsTo('User');
  }

}
