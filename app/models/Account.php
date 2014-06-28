<?php

class Account extends Eloquent {

  public function users()
  {
    return $this->belongsToMany('User')->withPivot('pending');
  }

  public function invites()
  {
    return $this->hasMany('Invite');
  }

}
