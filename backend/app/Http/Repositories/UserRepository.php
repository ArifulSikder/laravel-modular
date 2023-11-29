<?php

namespace App\Http\Repositories;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    private $model;
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return User::all();
    }
    public function store($request)
    {
        try {
            $item            = new $this->model();
            $item->name     = $request->name;
            $item->email     = $request->email;
            $item->password     = Hash::make($request->password);
            $item->save();
            return true;
        } catch (Exception $th) {
            dd($th);
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

}
