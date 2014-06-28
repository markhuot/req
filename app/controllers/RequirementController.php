<?php

class RequirementController extends BaseController {

  public function index(Account $account, Project $project)
  {
    return View::make('requirement.index')
      ->with('account', $account)
      ->with('project', $project)
      ->with('requirements', $project->requirements)
    ;
  }

  public function create(Account $account, Project $project)
  {
    return View::make('requirement.create');
  }

  public function store(Account $account, Project $project)
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

  public function show(Account $account, Project $project, Requirement $requirement)
  {
    return View::make('requirement.show')
      ->with('requirement', $requirement)
    ;
  }

  public function storeComment(Account $account, Project $project, Requirement $requirement)
  {
    $requirement->fill(Input::get('requirement'));

    $notes = [];
    foreach ($requirement->getDirty() as $key => $value) {
      $original = $requirement->getOriginal($key);
      $notes[] = 'updated '.$key.' from '.$original.' to '.$value;
    }

    $requirement->save();

    $comment = new Comment;
    $comment->fill(Input::get('comment'));
    $comment->notes = implode(', ', $notes);
    $requirement->comments()->save($comment);

    // if ($notes) {
    //   $notification = new Notification;
    //   $notification->user_id = 1;
    //   $notification->parent = 'Requirement';
    //   $notification->parent_key = $requirement->id;
    //   $notification->initiator = 'Comment';
    //   $notification->initiator_key = $comment->id;
    //   $notification->notes = implode(', ', $notes);
    //   $notification->save();
    // }

    return Redirect::route('requirement.show', $requirement->id);
  }

}
