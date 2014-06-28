<?php

class RequirementTableSeeder extends Seeder {

  public function run()
  {
    DB::table('requirements')->delete();

    Requirement::create([
      'project_id' => Project::where('name', '=', 'Test Project')->firstOrFail()->id,
      'title' => 'The application needs a secure login',
      'body' => 'The application needs a secure login More detail about how secure the login must be and how hard it will be to do this otherwise we risk the whole world finding out about our super secret plans and requirements.',
      'status' => 'accepted',
    ]);

    Requirement::create([
      'project_id' => Project::where('name', '=', 'Second Project')->firstOrFail()->id,
      'title' => 'Something Else?',
      'body' => 'foo.',
      'status' => 'rejected',
    ]);
  }

}
