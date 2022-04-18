<?php

namespace App\Http\Requests;


class UpdateUserFormRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'form_id' => 'required|exists:register_forms,id',
            'event_id' => 'required|exists:events,id',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'hobbies' => 'required|max:255'
        ];
    }
}
