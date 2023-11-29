<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CommonResource;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('name', 'asc')->where('parent_id', 0)->paginate();
        return apiSuccessResponse($permissions, 'Data fetched successfully', 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'display_name' => ['required', 'string', 'max:255', 'unique:permissions,display_name'],
        ]);

        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        
        $permission = Permission::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'display_name' => $request->display_name
        ]);

        if ($permission) {
            return apiSuccessResponse($permission = null, 'Data saved successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
        }
    }

    
    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $validator = Validator::make(['parent_id' => $id], [
            'parent_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        $data = $validator->validate();
        
        $permissions = Permission::where('parent_id', $data['parent_id'])->paginate();

        if ($permissions->count() > 0) {
            return apiSuccessResponse($permissions, 'Data fetched successfully', 201);
            // return apiSuccessResponse($result = new CommonResource($result), 'Data retrieved successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
        }
    }
  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name,' . $request->id . ',id',
        ],[
            'name.required' => 'Please Enter Permission Name!',
        ]);
        
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
      
        $permission = Permission::findOrFail($request->id)->update(['name' => $request->name]);

        if ($permission) {
            return apiSuccessResponse($permission = null, 'Data Updated successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id)->delete();
      
        if ($permission) {
            return apiSuccessResponse($permission = null, 'Data Deleted successfully');
        } else {
            return apiResponseCommonError($permission = null, 'Something is wrong!');
        }
    }
}
