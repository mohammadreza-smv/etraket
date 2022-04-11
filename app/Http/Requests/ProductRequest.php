<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'=>'required',
            'cat_id'=>'required',
            'description'=>'required|max:150',
        ];
    }
    public function attributes()
    {
        return [
            'title'=>'عنوان محصول',
            'cat_id'=>'دسته محصول',
            'description'=>'توضیحات مختصر',
        ];
    }
}
