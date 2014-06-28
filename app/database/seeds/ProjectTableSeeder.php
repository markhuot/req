<?php

class ProjectTableSeeder extends Seeder {

  public function run()
  {
    DB::table('projects')->delete();

    Project::create([
      'account_id' => Account::where('subdomain', '=', 'test')->first()->id,
      'name' => 'Test Project',
      'slug' => 'test-project',
    ]);

    Project::create([
      'account_id' => Account::where('subdomain', '=', 'test')->first()->id,
      'name' => 'Second Project',
      'slug' => 'second-project',
    ]);
  }

}
