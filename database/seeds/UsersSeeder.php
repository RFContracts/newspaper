<?php

use App\Eloquent\Role;
use App\Eloquent\User;
use Illuminate\Database\Seeder;
use App\Eloquent\Option;

/**
 * Class UsersSeeder
 */
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'default')->first();
        if (!$role) {
            $role = new Role();
            $role->name = 'default';
            $role->save();
        }
        $role = Role::where('name', 'admin')->first();

        if (!$role) {
            $role = new Role();
            $role->name = 'admin';
            $role->save();
        }

        User::register((object) array(
            'name' => 'Admin',
            'email' => 'admin@test.ru',
            'password' => 'secret_pass',
        ), 'admin');
    }
}
