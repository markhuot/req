<?php

class InviteController extends BaseController {

  public function accept(Account $account, Invite $invite)
  {
    if ($account->id != $invite->account->id) {
      throw new Exception('The account you are trying to register does not match the invite.');
    }

    Auth::user()->accounts()->attach($invite->account->id);
    $invite->delete();

    return Redirect::route('requirement.index');
  }

}
