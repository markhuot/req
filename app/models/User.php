<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

  public function accounts()
  {
    return $this->belongsToMany('Account')->withPivot('pending');
  }

  public function teams()
  {
    return $this->belongsToMany('Team');
  }

  public function getFullNameAttribute()
  {
    return implode(' ', [$this->attributes['first_name'], $this->attributes['last_name']]);
  }

  public function getAvatarAttribute()
  {
    $hash = md5(strtolower(trim($this->attributes['email'])));
    return "http://www.gravatar.com/avatar/{$hash}.jpg";
  }

}
