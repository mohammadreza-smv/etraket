<?php

namespace Modules\sellers\Http\Requests;

use App\Http\Requests\CFormRequest;
use App\Rules\CheckMobileNumberFormat;
use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends CFormRequest
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
            'fname' => 'required',
            'lname' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'brand_name' => 'required',
            'email' => 'required|email|unique:sellers,email,' . $this->list . '',
            'mobile' =>['required', 'unique:sellers,mobile,' . $this->list . '',new \Modules\sellers\Rules\CheckMobileNumberFormat()],
        ];
    }
}
