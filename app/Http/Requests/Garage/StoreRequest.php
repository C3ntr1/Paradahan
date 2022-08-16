<?php

namespace App\Http\Requests\Garage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => [
                'required',
                'max:16',
                'string',
                'alpha_dash',
                'unique:garages,name,'.$this->id,
            ],
            'location' => [
                'required',
                'max:250',
                'string',
            ],
            'lg' => [
                'min:0',
                'numeric',
                'nullable',
            ],
            'md' => [
                'min:0',
                'numeric',
                'nullable',
            ],
            'sm' => [
                'min:0',
                'numeric',
                'nullable',
            ],
        ];
    }

    public function messages()
    {
        return [
            'numeric' => 'This field must be a number.',
            'min' => 'This field must be a greater than 0.',
            'required' => 'This field is required',
        ];
    }
}
