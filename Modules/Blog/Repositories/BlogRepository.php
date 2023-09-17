<?php

namespace Modules\Blog\Repositories;

use Exception;
use Modules\Blog\Entities\Blog;
use Illuminate\Support\Facades\Log;

class BlogRepository
{
    private $model;
    public function __construct(Blog $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return Blog::all();
    }
    public function store($request)
    {
        try {
            $itemStore            = new $this->model();
            $itemStore->title     = $request->title;
            $itemStore->save();
            return true;
        } catch (Exception $th) {
            Log::info($th);
            return false;
        }
    }
}
