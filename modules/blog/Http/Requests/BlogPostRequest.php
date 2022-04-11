<?php

namespace Modules\blog\Http\Requests;

use App\Http\Requests\CFormRequest;

class BlogPostRequest extends CFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules=[
            'title'=>'required',
            'content'=>'required',
            'cat_id'=>'required',
            'pic'=>'image'
        ];
        if($this->getMethod()=='POST'){
            $rules['pic']='required|image';
        }
        return $rules;
    }

    public function attributes()
    {
        return [
            'title'=>'عنوان پست',
            'pic'=>'تصویر شاخص',
            'content'=>'توضیحات'
        ];
    }
}
