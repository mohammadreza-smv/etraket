<?php


namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use phpDocumentor\Reflection\Types\This;

class CFormRequest extends FormRequest
{
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        return $factory->make(
            $this->validationData(), $this->container->call([$this, 'CRules']),
            $this->messages(), $this->CAttributes()
        );
    }

    public function CRules(){
        $routeName=getRouteName();
        $action=$routeName.'_request';
        $rules=CompleteData($action,[
            'rules'=>$this->rules(),
            'self'=>$this
        ]);
        return $rules['rules'];
    }

    public function CAttributes(){

        $routeName=getRouteName();
        $routeName=str_replace('_store','',$routeName);
        $routeName=str_replace('_update','',$routeName);
        $action=$routeName.'_attributes';

        $attributes=CompleteData($action,$this->attributes());
        return $attributes;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json(['errors' => $errors],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY
            )
        );
    }
}
