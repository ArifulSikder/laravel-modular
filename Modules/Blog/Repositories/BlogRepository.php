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
            $item            = new $this->model();
            $item->title     = $request->title;
            $item->save();
            return true;
        } catch (Exception $th) {
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
            $item            = $this->model->find($request->id);
            $item->title     = $request->title;
            $item->save();
            return true;
        } catch (Exception $th) {
            Log::info($th);
            return false;
        }
    }

    public function destroy($id)
    {
        return Blog::destroy($id);
    }

}
