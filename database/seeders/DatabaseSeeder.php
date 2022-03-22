<?php

namespace Database\Seeders;

use Database\Factories\AdminUserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Storage::deleteDirectory('public/posts');
        Storage::makeDirectory('public/posts');

        \App\Models\User::factory(10)->create();
        \App\Models\Post::factory(10)->create();

        \App\Models\AdminUser::factory(1)->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);
    }
}
