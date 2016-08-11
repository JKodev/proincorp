<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('users')->insert([
    		'name'  =>  'admin',
		    'email' =>  'admin@proincorp.pe',
		    'password'  =>  bcrypt('admin123')
	    ]);
        // $this->call(UsersTableSeeder::class);
    }
}
