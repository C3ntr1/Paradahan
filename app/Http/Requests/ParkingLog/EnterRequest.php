<?php

namespace App\Http\Requests\ParkingLog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnterRequest extends FormRequest
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
            'plate_number' => [
                'required',
            ],
            'name' => [
                'required',
            ],
            'mobile_number' => [
                'required',
                'numeric',
                'digits:11'
            ],
            'type' => [
                'required',
            ]
        ];
    }
}
