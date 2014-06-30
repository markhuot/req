<?php

class RequirementController extends BaseController {

  public function index(Account $account, Project $project)
  {
    return View::make('requirement.index')
      ->with('project', $project)
      ->with('requirements', $project->requirements)
    ;
  }

  public function create(Account $account, Project $project)
  {
    return View::make('requirement.create')
      ->with('project', $project)
    ;
  }

  public function store(Account $account, Project $project)
  {
    $requirement = new Requirement;
    $requirement->fill(Input::get('requirement'));

    $project->requirements()->save($requirement);

    switch(Input::get('action')) {
      case 'addMore':
        return Redirect::route('requirement.create');
      break;

      default:
        return Redirect::route('requirement.show', [$account->subdomain, $project->slug, $requirement->id]);
    }
  }

  public function show(Account $account, Project $project, Requirement $requirement)
  {
    return View::make('requirement.show')
      ->with('project', $project)
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

    $before = $requirement->assignments->modelKeys();
    sort($before);
    $after = Input::get('requirement.assignments', []);
    sort($after);

    if (array_diff($before, $after) || array_diff($after, $before)) {
      $requirement->assignments()->sync($after);
      if (empty($after)) {
        $notes[] = 'removed all assignments';
      }
      else {
        $notes[] = 'changed the assignment to '.implode(', ', $requirement->assignments()->get()->lists('fullName'));
      }
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

    return Redirect::route('requirement.show', [$account->subdomain, $project->slug, $requirement->id]);
  }

  public function storeHighlight(Account $account, Project $project, Requirement $requirement, Comment $comment)
  {
    $highlight = new Highlight;
    $highlight->comment_id = $comment->id;
    $highlight->user_id = Auth::user()->id;
    $highlight->before = Input::get('highlight.before');
    $highlight->start = Input::get('highlight.start');
    $highlight->text = Input::get('highlight.text');
    $highlight->end = Input::get('highlight.end');
    $highlight->after = Input::get('highlight.after');
    $highlight->save();

    $comment = new Comment;
    $comment->notes = 'highlighted '.$highlight->text;
    $requirement->comments()->save($comment);

    return Response::json($highlight);
  }

  public function deleteHighlight(Account $account, Project $project, Requirement $requirement, Comment $comment, Highlight $highlight)
  {
    $highlight->delete();

    return Redirect::route('requirement.show', [$account->subdomain, $project->slug, $requirement->id]);
  }

}
