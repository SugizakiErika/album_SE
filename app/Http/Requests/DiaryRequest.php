<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiaryRequest extends FormRequest
{
    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     return false;
    // }

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
            'file.*' => 'required|file|image|mimes:gif,jpg,jpeg,png',
        ];
    }
}
