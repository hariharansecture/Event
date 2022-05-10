<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class EventRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = request('id');
        return $rules = [
            'event_name' => 'required|string',
            'start_date' => 'required|before:end_date',
            'end_date' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'event_name.required' => 'Bank Name is required.',

            'start_date.required' => 'Bank Code is required.',

            'end_date.required' => 'The Bank Code should not exceed 255 characters.',
        ];
    }
}
