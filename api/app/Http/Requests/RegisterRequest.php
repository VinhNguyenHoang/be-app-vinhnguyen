<?php

namespace App\Http\Requests;


class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => 'required|exists:events,id',
            'email' => 'required|email:rfc,dns',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'hobbies' => 'required|max:255'
        ];
    }
}
