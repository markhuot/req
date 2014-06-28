<?php

class SettingsController extends BaseController {

  public function users(Account $account)
  {
    return View::make('settings.users')
      ->with('users', $account->users)
    ;
  }

  public function postUser(Account $account)
  {
    $invite = new Invite;
    $invite->email = Input::get('invite.email');
    $account->invites()->save($invite);

    return Redirect::back();
  }

  public function projects(Account $account)
  {
    return View::make('settings.projects')
      ->with('projects', $account->projects)
    ;
  }

  public function postProject(Account $account)
  {
    $project = new Project;
    $project->name = Input::get('project.name');
    $project->slug = Input::get('project.slug', slug_case($project->name));

    $account->projects()->save($project);
    return Redirect::route('settings.projects', $account->subdomain);
  }

}
