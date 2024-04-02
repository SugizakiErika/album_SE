<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Facades\Log;

class MyEventRequest extends FormRequest
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
            'myevent.title' => 'required|string|max:30',
            'myevent.category' => 'required',
            'myevent.start' => 'required|date|date_format:Y-m-d',
            'myevent.day' => 'required|regex:/^[0-9]+$/i',
        ];
    }
    
    
}
