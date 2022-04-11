<?php


namespace Modules\fileManager\Http\Request;


use App\Http\Requests\CFormRequest;

class UploadRequest extends CFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file'=>'image'
        ];
    }

    public function attributes()
    {
        return [
            'file'=>'فایل انتخابی'
        ];
    }
}
