<?php

namespace Modules\Blog\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                "data" => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            "code" => 200,
            "message" => "Data retrieved successfully",
            "data" => [
                "items" => $items
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $validatedData)
    {
        $product = $this->blogRepo->create($validatedData);
        return response()->json([
            "code" => 200,
            "message" => "Data saved successfully"
        ]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}