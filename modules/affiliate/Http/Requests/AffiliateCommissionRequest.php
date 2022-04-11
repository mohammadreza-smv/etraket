<?php

namespace Modules\affiliate\Http\Requests;

use App\Http\Requests\CFormRequest;

class AffiliateCommissionRequest extends CFormRequest
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
         return  [
             'cat_id'=>'required',
             'brand_id'=>'required',
             'percentage'=>'required|numeric'
         ];
    }

    public function attributes()
    {
        return  [
            'cat_id'=>'دسته',
            'brand_id'=>'برند',
            'percentage'=>'درصد کمیسیون'
        ];
    }
}
