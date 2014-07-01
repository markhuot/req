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

  public function icon()
  {
    switch ($this->attributes['type']) {
      case 'highlight':
        return 'fa-quote-right';
      case 'tag':
        return 'fa-tags';
      case 'assignment':
        return 'fa-user';
      default:
        return 'fa-comment';
    }
  }

  public function getNotesAttribute()
  {
    return json_decode($this->attributes['notes']);
  }

}
