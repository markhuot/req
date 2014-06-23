<?php

class Comment extends Eloquent {

  protected $fillable = [
    'body',
  ];

  public function requirement()
  {
    return $this->belongsTo('Requirement');
  }

}
