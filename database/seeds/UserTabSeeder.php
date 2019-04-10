<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTabSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username= 'admin';
        $user->password = bcrypt('test_pw');
        $user->level = 10;
        $user->status = 1;
        $user->rememberToken = 'new';
        $user->save();
    }
}
