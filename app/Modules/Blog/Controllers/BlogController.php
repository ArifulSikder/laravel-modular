<?php
// app/Modules/Blog/Controllers/BlogController.php

namespace App\Modules\Blog\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        dd('asdf');
    }

    public function edit($id)
    {
        dd($id);
    }
    public function update(Request $request, $id){
        dd($id);
    }

    public function delete($id){
        dd($id);
    }
}
