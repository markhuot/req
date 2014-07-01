<?php

class TagController extends BaseController {

  public function index(Account $account, Project $project)
  {
    return Response::json($project->tags);
  }

  public function store(Account $account, Project $project)
  {
    $tag = new Tag;
    $tag->name = Input::get('text');
    $project->tags()->save($tag);

    return Response::json($tag);
  }

}
