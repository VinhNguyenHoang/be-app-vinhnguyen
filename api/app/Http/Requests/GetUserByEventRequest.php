<?php

namespace App\Http\Requests;


class GetUserByEventRequest extends BaseRequest
{
    protected function prepareForValidation() {
        $this->merge(['event_id' => $this->route('event_id')]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event_id' => 'required|exists:events,id'
        ];
    }
}
