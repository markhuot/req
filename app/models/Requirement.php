<?php

class Requirement extends Eloquent {

  protected $fillable = [
    'title',
    'body',
    'status',
  ];

  public static function boot()
  {
    Requirement::saving(function($requirement) {
      if (trim(@$requirement->title) == '') {
        $requirement->title = substr($requirement->body, 0, 55);
      }
    });
  }

  public function comments()
  {
    return $this->hasMany('Comment');
  }

  public function assignments()
  {
    return $this->belongsToMany('User', 'requirement_assignment');
  }

  public function highlights()
  {
    return $this->hasManyThrough('Highlight', 'Comment');
  }

  public function tags()
  {
    return $this->belongsToMany('Tag');
  }

}
