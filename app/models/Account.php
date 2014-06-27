<?php

class Account extends Eloquent {

  public function users()
  {
    return $this->belongsToMany('User');
  }

  public function invites()
  {
    return $this->hasMany('Invite');
  }

}
