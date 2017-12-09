<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
     * @return array
     */

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:6'
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
            'name.required' => 'O campo Nome é obrigatório!',
            'name.min' => 'O campo Nome precisa ter pelo menos 3 caracteres',

            'email.required' => 'O campo Email é obrigatório!',
            'email.email' => 'O campo Email não esta correto!',

            'password.required' => 'O campo Senha é obrigatório!',
            'password.min' => 'O campo Senha precisa ter pelo menos 6 caracteres',

        ];
    }
}
