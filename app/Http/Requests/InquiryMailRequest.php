<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class InquiryMailRequest extends FormRequest
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
            'inquiry.title' => 'required|string|max:30',
            'inquiry.comment' => 'required|string|max:400',
            'inquiry.user_id' => 'required|string|max:100',
            'inquiry.email' => 'required|email:filter,dns,strict,spoof',
        ];
    }
}
