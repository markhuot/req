<?php

class AccountTableSeeder extends Seeder {

  public function run()
  {
    DB::table('accounts')->delete();
    Account::create([
      'name' => 'Test Company',
      'subdomain' => 'test',
    ]);
  }

}
