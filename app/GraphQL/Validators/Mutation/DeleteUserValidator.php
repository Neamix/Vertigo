<?php

namespace App\GraphQL\Validators\Mutation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Validation\Validator;

final class DeleteUserValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'input.id' => ['required','exists:users,id'],
            'input.password' => ['required',
                function($attribute,$value,$fail) {
                    if ( ! Hash::check($value,Auth::user()->password) ) {
                        return $fail('Wrong password,please check your password and try again');
                    }
                }
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'input.password.required' => "To confirm this action , you have to enter your password"
        ];   
    }
}
