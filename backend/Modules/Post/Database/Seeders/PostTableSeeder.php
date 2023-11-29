<?php

namespace Modules\Post\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Post\Entities\Post;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();
        $title = Str::random(5);
        $data = [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => Str::random(10),
        ];

        Post::create($data);

        // $this->call("OthersTableSeeder");
    }
}
