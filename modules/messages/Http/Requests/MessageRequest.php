<?php

namespace Modules\messages\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
        $rules= [
            'content' => 'required',
            'pic'=> 'file|mimes:png,jpg,jpeg,pdf,txt,rtf|max:1024'
        ];
        if($this->method()=="POST"){
            $rules['title']='required';
        }
        return $rules;
    }
}
