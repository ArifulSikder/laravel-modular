<?php

namespace Modules\Post\Repositories;

use Exception;
use Modules\Blog\Entities\Blog;
use Illuminate\Support\Facades\Log;
use Modules\Post\Entities\Post;
use Illuminate\Support\Str;

class PostRepository
{
    private $model;
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->latest()->get();
    }

    public function store($request)
    {
        try {
            $item = new $this->model();
            $item->title = $request->title;
            $item->slug = Str::slug($request->title);
            $item->description = $request->description;
            $item->save();
            return true;
        } catch (\Exception $th) {
            Log::info($th);
            return false;
        }
    }
    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function update($request)
    {
        try {
            $item = $this->model->find($request->id);
            $item->title = $request->title;
            $item->slug = Str::slug($request->title);
            $item->description = $request->description;
            $item->save();
            return true;
        } catch (\Exception $th) {
            Log::info($th);
            return false;
        }
    }

    
    public function destroy($id)
    {
        return $this->model::destroy($id);
    }
}