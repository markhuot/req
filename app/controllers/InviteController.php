<?php

class InviteController extends BaseController {

  public function request(Account $account)
  {
    if (!$account->users->contains(Auth::user())) {
      $account->users()->attach(Auth::user()->id, ['pending' => true]);
    }

    return View::make('login.request');
  }

  public function accept(Account $account, Invite $invite)
  {
    if ($account->id != $invite->account->id) {
      throw new Exception('The account you are trying to register does not match the invite.');
    }

    if (!Auth::user()->accounts->contains($invite->account->id)) {
      Auth::user()->accounts()->attach($invite->account->id);
    }

    $account = Auth::user()->accounts()->where('account_id', '=', $invite->account->id)->firstOrFail();
    $account->pivot->pending = 0;
    $account->pivot->save();

    $invite->delete();

    return Redirect::route('requirement.index', $account->subdomain);
  }

  public function approve(Account $account, User $user)
  {
    $user = $account->users()->where('user_id', '=', $user->id)->firstOrFail();
    $user->pivot->pending = 0;
    $user->pivot->save();
    return Redirect::back();
  }

}
