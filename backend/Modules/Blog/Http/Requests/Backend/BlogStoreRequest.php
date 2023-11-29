<?php

namespace Modules\Blog\Http\Requests\Backend;

use Illuminate\Routing\Controller;

class BlogStoreRequest extends Controller
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {

        return [
            'title' => 'required|string|max:255'
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'The name field is required.',
            'title.string' => 'The name must be a string.',
            'title.max' => 'The name may not be greater than 255 characters.'
        ];
    }
}
