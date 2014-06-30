<?php

use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Eloquent {

  protected $fillable = [
    'body',
  ];

  public function requirement()
  {
    return $this->belongsTo('Requirement');
  }

  public function notifications()
  {
    return Notification::where('initiator', '=', 'Comment')->where('initiator_key', '=', $this->id);
  }

  public function highlights()
  {
    return $this->hasMany('Highlight');
  }

}
