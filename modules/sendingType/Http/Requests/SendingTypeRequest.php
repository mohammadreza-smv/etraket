<?php

namespace Modules\sendingType\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendingTypeRequest extends FormRequest
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
            'type_name'=>'required',
            'type_key'=>'required|alpha_dash|regex:/^[A-Za-z][A-Za-z0-9]*$/|unique:send_type_order,type_key,'.$this->sending_type.'',
            'weight1'=>'required',
            'weight2'=>'required',
            'send_type_name'=>'required',
            'pic'=>'image',
        ];
    }
    public function attributes()
    {
        return [
            'type_name'=>'عنوان',
            'type_key'=>'عنوان لاتین',
            'weight1'=>'وزن اولیه',
            'weight2'=>'وزن نهایی',
            'send_type_name'=>'شیوه ارسال مرسوله',
            'pic'=>'ایکون',
        ];
    }
}
