<?php

class TeamTableSeeder extends Seeder {

  public function run()
  {
    DB::table('teams')->delete();

    Team::create([
      'account_id' => Account::where('subdomain', '=', 'happycog')->first()->id,
      'name' => 'Designers',
    ]);

    Team::create([
      'account_id' => Account::where('subdomain', '=', 'happycog')->first()->id,
      'name' => 'Developers',
    ]);
  }

}
