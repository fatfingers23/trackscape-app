<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OSRSChatRequest extends FormRequest
{

    protected $clanName;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        if(\Auth::authenticate()){
//            return true;
//        }

//        ray(\Auth::user());
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
            //
            '*.clanName' => 'required',
            '*.sender' => 'required',
            '*.message' => 'required'
        ];
    }
}
