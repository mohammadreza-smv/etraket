<?php

namespace Modules\blog\Http\Requests;

use App\Http\Requests\CFormRequest;

class BlogCategoryRequest extends CFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required',
            'parent_id'=>'required'
        ];
    }

    public function attributes()
    {
        return [
            'name'=>'نام دسته',
            'parent_id'=>'سر دسته',
        ];
    }
}
