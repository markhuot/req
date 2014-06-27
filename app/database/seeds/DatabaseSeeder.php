<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

    $this->call('AccountTableSeeder');
    $this->call('TeamTableSeeder');
    $this->call('UserTableSeeder');
		$this->call('RequirementTableSeeder');
    $this->command->info('User table seeded!');
	}

}
