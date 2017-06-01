<?php

use Illuminate\Database\Seeder;
use Martin\ACL\Role;
use Martin\ACL\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        $users = env('USER_USERS');
        $users = explode(',', $users);
        foreach ($users as $user)
        {
            if (env($user.'_NAME', null) != null){
                User::create([
                    'name' => env($user .'_NAME'),
                    'email' => env($user .'_EMAIL'),
                    'password' => bcrypt(env($user.'_PASS')),
                ]);
            }
        }

        $clients = env('CLIENT_USERS');
        $clients = explode(',', $clients);
        foreach($clients as $client) {
            if (env($client . '_NAME', null) != null) {
                User::create([
                    'name' => env($client . '_NAME'),
                    'email' => env($client . '_EMAIL'),
                    'password' => bcrypt(env($client . '_PASS')),
                ]);
            }
        }
//
//        $admin = User::where('name', 'Admin')->firstOrFail();
//        $admin->assignRole('admin');
//
//        $bri = User::where('name', 'Brianna Martin')->firstOrFail();
//        $bri->assignRole('admin');
//
//        $viv = User::where('name', 'Vivian Wong')->firstOrFail();
//        $viv->assignRole('admin');
    }
}
