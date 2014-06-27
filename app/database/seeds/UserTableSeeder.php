<?php

class UserTableSeeder extends Seeder {

  public function run()
  {
    DB::table('users')->delete();
    DB::table('account_user')->delete();

    $mark = User::create([
      'first_name' => 'Mark',
      'last_name' => 'Huot',
      'email' => 'mark@markhuot.com',
      'password' => Hash::make('howdy'),
    ]);
    $mark->accounts()->attach(Account::where('subdomain', '=', 'happycog')->first()->id);
    $mark->teams()->attach(Team::where('name', '=', 'Developers')->first()->id);

    $jack = User::create([
      'first_name' => 'Jack',
      'last_name' => 'Bauer',
      'email' => 'jack@ctu.gov',
      'password' => Hash::make('howdy'),
    ]);
    $jack->accounts()->attach(Account::where('subdomain', '=', 'happycog')->first()->id);
    $jack->teams()->attach(Team::where('name', '=', 'Developers')->first()->id);
  }

}
