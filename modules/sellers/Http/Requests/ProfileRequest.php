<?php

namespace Modules\sellers\Http\Requests;

use App\Http\Requests\CFormRequest;
use Modules\sellers\Rules\CheckIBANCode;

class ProfileRequest extends CFormRequest
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
        $rules=[
            'fname' => 'required',
            'lname' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'brand_name' => 'required',
            'email' => 'required|email|unique:sellers,email,' . $this->id . '',
            'mobile' =>['required', 'unique:sellers,mobile,' . $this->id . '',new \Modules\sellers\Rules\CheckMobileNumberFormat()],
        ];

        if(!empty($this->get('password')))
        {
            $rules['password']='required|min:6';
        }
        if(!empty($this->get('shaba')))
        {
            $rules['shaba']=[new CheckIBANCode()];
        }
        if($this->hasFile('shenasname'))
        {
            $rules['shenasname']=['image'];
        }
        if($this->hasFile('cart'))
        {
            $rules['cart']=['image'];
        }
        if($this->hasFile('rooznamepic'))
        {
            $rules['rooznamepic']=['image'];
        }

        return $rules;
    }
}
