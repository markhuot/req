<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        User::create(array('email' => 'mark@markhuot.com', 'password' => Hash::make('howdy')));
    }

}
