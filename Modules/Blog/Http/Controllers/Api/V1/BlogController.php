<?php

namespace Modules\Blog\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Blog\Http\Resources\PostResource;
use Modules\Blog\Repositories\BlogRepository;

class BlogController extends Controller
{
    protected $blogRepo;
    public function __construct(BlogRepository $blogRepo)
    {
        $this->blogRepo = $blogRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $items = $this->blogRepo->getAll();
        if ($items->isEmpty()) {
            return response()->json([
                'success' => false,
                "code" => 404,
                "message" => "No items found",
                "items" => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            "code" => 200,
            "message" => "Data retrieved successfully",
            "items" => new PostResource($items)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|max:255|unique:blogs,title'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                "code" => 400,
                "message" =>  $validator->errors()->all()[0],
                "items" => []
            ]);
        }
        $result =  $this->blogRepo->store($request);
        if ($result) {
            return response()->json([
                "success" => true,
                "code" => 200,
                "message" => "Data saved successfully"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "code" => 400,
                "message" => "Something went wrong please try again"
            ]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                "code" => 400,
                "message" =>  $validator->errors()->all()[0],
                "items" => []
            ]);
        }

        $result = $this->blogRepo->findById($request->id);
        if ($result) {
            return response()->json([
                "success" => true,
                "code" => 200,
                "message" => "Data retrieved successfully",
                "item" => new PostResource($result)
            ]);
        } else {
            return response()->json([
                "success" => false,
                "code" => 400,
                "message" => "Something went wrong please try again"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blogs')->ignore($request->id),
            ],
        ]);
        // dd($request->all(), $validator);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                "code" => 400,
                "message" =>  $validator->errors()->all()[0],
                "items" => []
            ]);
        }

        $result =  $this->blogRepo->update($request);
        if ($result) {
            return response()->json([
                "success" => true,
                "code" => 200,
                "message" => "Data updated successfully"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "code" => 400,
                "message" => "Something went wrong please try again"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                "code" => 400,
                "message" =>  $validator->errors()->all()[0],
            ]);
        }
        $result = $this->blogRepo->destroy($request->id);

        if ($result) {
            return response()->json(['message' => 'Data deleted successfully']);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }
}
