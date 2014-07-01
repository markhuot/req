<?php

class Project extends Eloquent {

  public function account()
  {
    return $this->belongsTo('Account');
  }

  public function requirements()
  {
    return $this->hasMany('Requirement');
  }

  public function tags()
  {
    return $this->hasMany('Tag');
  }

}
