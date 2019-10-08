<?php

use App\Blog;
use App\Tag;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(User::class, 5)->create();
        factory(Tag::class, 5)->create();
        factory(Blog::class, 100)->create();
    }
}
