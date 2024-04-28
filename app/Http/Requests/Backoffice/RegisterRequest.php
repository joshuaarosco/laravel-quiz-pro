<?php

namespace App\Http\Requests\Backoffice;

use Illuminate\Foundation\Http\FormRequest;
use Input;

class RegisterRequest extends FormRequest
{

    public function __construct(){
        $this->userType = Input::get('user_type');
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return in_array($this->userType, ['professor', 'student']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        $newRules = [];
        $rules = [
            'fname' => "required",
            'lname' => "required",
            'email' => "required|unique:users,email",
            'password' => "confirmed|min:8",
            'password_confirmation' => "required",
        ];

        if($this->userType == 'professor'){
            $newRules = [
                'department' => "required",
            ];
        }

        return array_merge($rules,$newRules);
    }
}
