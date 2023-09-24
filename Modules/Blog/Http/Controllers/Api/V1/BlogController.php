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
            'title' => 'required|string|min:10|max:255|unique:blogs,title'
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        $result =  $this->blogRepo->store($request);
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
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        // dd($validator);
        $result = $this->blogRepo->findById($request->id);

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
            'id' => 'required',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('blogs')->ignore($request->id),
            ],
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }

        $result =  $this->blogRepo->update($request);
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
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        $result = $this->blogRepo->destroy($request->id);

        if ($result) {
            // return response()->json(['message' => 'Data deleted successfully']);
            return apiSuccessResponse($result = null, 'Data deleted successfully');
        } else {
            return apiErrorResponse($result = null, "Data not found");
        }
    }
}
