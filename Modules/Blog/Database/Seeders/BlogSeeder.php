<?php

namespace Modules\Blog\Database\Seeders;
use Illuminate\Database\Seeder;
use Modules\Blog\Entities\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'title' => 'Post title',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        Blog::insert($data);
    }
}
