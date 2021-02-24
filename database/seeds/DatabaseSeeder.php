<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('migrate:refresh');
        $this->call(UsersSeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(PostsSeeder::class);

        Artisan::call('passport:install');
    }
}
