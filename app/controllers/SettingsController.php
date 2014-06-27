<?php

class SettingsController extends BaseController {

  public function users(Account $account)
  {
    return View::make('settings.users')
      ->with('account', $account)
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

}
