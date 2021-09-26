<?php

namespace App\Http\Requests\HospitalRoomRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalRoomRequest extends FormRequest
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
            'hospital_id' => [
                'required',
                'exists:hospitals,id',
            ],
            'room_no' => 'string|required',
            'status' => 'default:0'
        ];
    }
}
