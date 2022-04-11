<?php

namespace Modules\city\Http\Requests;

use App\Http\Requests\CFormRequest;

class CityRequest extends CFormRequest
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
            'name'=>'required',
            'province_id'=>'required'
        ];
        foreach ($this->all() as $key=>$value){
            if($key!="_token" && $key!="name" && $key!="province_id" && $key!="_method"){
                $rules[$key]='numeric';
            }
        }
        return  $rules;
    }
    public function attributes()
    {
        return [
            'name'=>'نام شهر',
            'province_id'=>'استان'
        ];
    }
    protected function getValidatorInstance()
    {
        foreach ($this->all() as $key=>$value){
            if($key!="_token" && $key!="name" && $key!="province_id" && $key!="_method"){
                $this->merge([
                    $key=>str_replace(',','',$value)
                ]);
            }
        }

        return parent::getValidatorInstance();
    }
}

