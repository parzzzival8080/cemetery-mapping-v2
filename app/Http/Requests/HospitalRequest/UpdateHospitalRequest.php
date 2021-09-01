<?php

namespace App\Http\Requests\HospitalRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalRequest extends FormRequest
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
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'role' => 'required|in:OWNER',

            'name' => 'required|min:8',
            'number' => 'required|min:8',

            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
        ];
    }
}
