<?php

namespace App\GraphQL\Validators;

use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Validation\Validator;

final class UserInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'email' => ['required','email',function($value,$attribute,$fail){
                $checkCredintions = Auth::attempt(['email' => $this->arg('email'),'password' => $this->arg('password')]);
                
                if ( ! $checkCredintions ) {
                    return $fail('Wrong credintions please check your email and password');
                }
            }],
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Please enter a valid email',
        ];  
    }
}
