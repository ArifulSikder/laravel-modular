<?php
namespace Modules\Blog\Repositories;
use Modules\Blog\Entities\Blog;

class BlogRepository
{
    public function getAll()
    {
        return Blog::all();
    }
    public function create(array $data)
    {
        return Blog::create($data);
    }
}
