<?php

class Tag extends Eloquent {

  public function requirements()
  {
    return $this->hasMany('Requirement');
  }

}
