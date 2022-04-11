<?php

namespace Modules\sendingType\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        if($this->isMethod('post'))
        {
            $rules=[];
            foreach ($this->all() as $key=>$value){
                if($key!="_token"){
                   if(!empty($value)){
                       $rules[$key]='numeric';
                   }
                }
            }
            return $rules;
        }
        else{
            return  [];
        }

    }
    public function attributes()
    {
        return [];
    }
    protected function getValidatorInstance()
    {
        foreach ($this->all() as $key=>$value){
            if($key!="_token"){
                $this->merge([
                    $key=>str_replace(',','',$value)
                ]);
            }
        }
        return parent::getValidatorInstance();
    }
}
