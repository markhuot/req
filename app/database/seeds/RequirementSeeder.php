<?php

class RequirementTableSeeder extends Seeder {

  public function run()
  {
    DB::table('requirements')->delete();

    $testProject = Project::where('name', '=', 'Test Project')->firstOrFail()->id;
    $user = User::first();
    $lorem = ['Lorem','ipsum','dolor','sit','amet,','consectetur','adipisicing','elit,','sed','do','eiusmod','tempor','incididunt','ut','labore','et','dolore','magna','aliqua.','Ut','enim','ad','minim','veniam,','quis','nostrud','exercitation','ullamco','laboris','nisi','ut','aliquip','ex','ea','commodo','consequat.','Duis','aute','irure','dolor','in','reprehenderit','in','voluptate','velit','esse','cillum','dolore','eu','fugiat','nulla','pariatur.','Excepteur','sint','occaecat','cupidatat','non','proident,','sunt','in','culpa','qui','officia','deserunt','mollit','anim','id','est','laborum'];
    $statuses = ['pending', 'accepted', 'rejected', 'delivered', 'closed'];

    Requirement::create([
      'project_id' => $testProject,
      'title' => 'The application needs a secure login',
      'body' => 'The application needs a secure login More detail about how secure the login must be and how hard it will be to do this otherwise we risk the whole world finding out about our super secret plans and requirements.',
      'status' => 'accepted',
    ]);

    for ($i=0; $i<100; $i++) {
      shuffle($lorem);
      $title = implode(' ', array_slice($lorem, 0, rand(5,10)));
      shuffle($lorem);
      $body = implode(' ', array_slice($lorem, 0, rand(100,200)));
      $statusKey = array_rand($statuses);

      $requirement = Requirement::create([
        'project_id' => $testProject,
        'title' => ucfirst($title),
        'body' => ucfirst($body),
        'status' => $statuses[$statusKey],
      ]);

      $requirement->assignments()->sync([$user->id]);
    }

    Requirement::create([
      'project_id' => Project::where('name', '=', 'Second Project')->firstOrFail()->id,
      'title' => 'Something Else?',
      'body' => 'foo.',
      'status' => 'rejected',
    ]);
  }

}
