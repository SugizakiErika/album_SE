<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiaryRequest extends FormRequest
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
            'diary.title' => 'required|string|max:30',
            'diary.comment' => 'required|string|max:200',
            'diary.start' => 'required|date|date_format:Y-m-d',
            'files.*' => 'required|file|image|mimes:gif,jpg,jpeg,png',
            //'files.image' => 'required|array|min:1',
            'files' => 'required|array|min:1',
        ];
    }
}
