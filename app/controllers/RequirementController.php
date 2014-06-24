<?php

class RequirementController extends BaseController {

  public function index()
  {

  }

  public function create()
  {
    return View::make('requirement.create');
  }

  public function store()
  {
    $requirement = new Requirement;
    $requirement->fill(Input::get('requirement'));
    $requirement->save();

    switch(Input::get('action')) {
      case 'addMore':
        return Redirect::route('requirement.create');
      break;

      default:
        return Redirect::route('requirement.show', $requirement->id);
    }
  }

  public function show(Requirement $requirement)
  {
    return View::make('requirement.show')
      ->with('requirement', $requirement)
    ;
  }

  public function storeComment(Requirement $requirement)
  {
    $requirement->fill(Input::get('requirement'));

    $notes = [];
    if (Input::get('comment.body')) {
      $notes[] = 'added a comment';
    }
    foreach ($requirement->getDirty() as $key => $value) {
      $original = $requirement->getOriginal($key);
      $notes[] = 'updated '.$key.' from '.$original.' to '.$value;
    }

    $requirement->save();

    $comment = new Comment;
    $comment->fill(Input::get('comment'));
    $requirement->comments()->save($comment);

    if ($notes) {
      $notification = new Notification;
      $notification->user_id = 1;
      $notification->parent = 'Requirement';
      $notification->parent_key = $requirement->id;
      $notification->initiator = 'Comment';
      $notification->initiator_key = $comment->id;
      $notification->notes = implode(', ', $notes);
      $notification->save();
    }

    return Redirect::route('requirement.show', $requirement->id);
  }

}
