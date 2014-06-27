<?php

class LoginController extends BaseController {

  public function login(Account $account)
  {
    return View::make('login.index')
      ->with('account', $account)
    ;
  }

  public function postLogin(Account $account)
  {
    $email = Input::get('user.email');
    $password = Input::get('user.password');

    if (Auth::attempt(array('email' => $email, 'password' => $password))) {
        return Redirect::intended();
    }

    return Redirect::route('login', $account->subdomain);
  }

  public function register(Account $account)
  {
    return View::make('login.register')
      ->with('account', $account)
    ;
  }

  public function postRegister(Account $account)
  {
    $user = new User;
    $user->first_name = Input::get('user.first_name');
    $user->last_name = Input::get('user.last_name');
    $user->email = Input::get('user.email');
    $user->password = Hash::make(Input::get('user.password'));
    $user->save();

    $account->users()->attach($user->id);

    Auth::loginUsingId($user->id);

    return Redirect::intended();
  }

  public function logout(Account $account)
  {
    Auth::logout();
    return Redirect::route('login', $account->subdomain);
  }

}
