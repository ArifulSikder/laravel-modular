<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\Post\Repositories\PostRepository;
use Modules\Post\Transformers\PostResource;

class PostController extends Controller
{
    protected $postRepo;
    public function __construct(PostRepository $postRepo)
    {
        $this->postRepo = $postRepo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $items = $this->postRepo->getAll();
        if ($items->isEmpty()) {
            return apiErrorResponse($items);
        }
        return apiSuccessResponse($items, 'Data fetched successfully', 201);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|max:255|unique:posts,title',
            'description' => 'required|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }

        $result = $this->postRepo->store($request);

        if ($result) {
            return apiSuccessResponse($result = null, 'Data saved successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
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
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }

        $result = $this->postRepo->findById($request->id);

        if ($result) {
            return apiSuccessResponse($result = new PostResource($result), 'Data retrieved successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
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
            'title' => "required|string|min:10|max:255|unique:posts,title,{$request->id}",
            'description' => 'required|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }

        $result = $this->postRepo->update($request);

        if ($result) {
            return apiSuccessResponse($result = null, 'Data updated successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
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
            'id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }

        $result = $this->postRepo->destroy($request->id);

        if ($result) {
            return apiSuccessResponse($result = null, 'Data deleted successfully');
        } else {
            return apiErrorResponse($result = null, 'Data not found');
        }
    }
}
