<?php

namespace App\Http\Requests\RoomRequestRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hospital_room_id' => [
                'required',
                'exists:hospital_rooms,id',
            ],
            'occupant_id' => [
                'required',
                'exists:hospitals,id',
            ],
        ];
    }
}
