<?php

namespace App\Http\Requests;

class ¤ModelP¤Request extends FormRequest
{
    /**
     * Transform datatypes before any validation is done
     *
     * @var array
     */
    public $transform = [
        //
    ];

    /**
     * Default validations for the ¤ModelP¤Request
     *
     * @var array
     */
    private $¤modelC¤Request = [
        //
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'PUT': {
                return true;
            }
            case 'POST': {
                return true;
            }
            case 'GET': {
                return true;
            }
            case 'PATCH': {
                return true;
            }
            case 'DELETE': {
                return true;
            }
            default: {
                return false;
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'PUT': {
                return $this->¤modelC¤Request;
            }
            case 'POST': {
                return $this->¤modelC¤Request;
            }
            case 'PATCH': {
                return $this->¤modelC¤Request;
            }
            case 'GET': {
                return ['¤modelC¤_id'];
            }
            case 'DELETE': {
                return ['¤modelC¤_id'];
            }
            default: {
                return $this->¤modelC¤Request;
            }
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'required' => trans('validation.required'),
            'attribute.required' => 'Custom message for specific validation',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'attribute' => trans('¤modelC¤.attribute'),
        ];
    }
}
