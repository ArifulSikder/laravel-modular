<?php

namespace App\Http\Controllers\Acl;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->paginate();
        return apiSuccessResponse($roles, 'Data fetched successfully', 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
        ]);

        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        $role = Role::create(['name' => $request->name]);
        if ($role) {
            return apiSuccessResponse($role = null, 'Data saved successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
        }
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
        // dd($validator);
        $result = Role::findOrFail($id);

        if ($result) {
            return apiSuccessResponse($result = new CommonResource($result), 'Data retrieved successfully');

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
            'name' => 'required|string|max:255|unique:roles,name,' . $request->id . ',id',
        ],[
            'name.required' => 'Please Enter Role Name!',
        ]);
        
        if ($validator->fails()) {
            return apiValidationErrorResponse($validator->errors(), 'Validation Error');
        }
      
        $role = Role::findOrFail($request->id)->update(['name' => $request->name]);

        if ($role) {
            return apiSuccessResponse($role = null, 'Data Updated successfully');
        } else {
            return apiResponseCommonError($validator->errors(), 'Validation Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id)->delete();
      
        if ($role) {
            return apiSuccessResponse($role = null, 'Data Deleted successfully');
        } else {
            return apiResponseCommonError($data = null, 'Something is wrong!');
        }
    }
}
