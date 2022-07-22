<?php

namespace App\GraphQL\Validators;

use Illuminate\Support\Facades\DB;
use Nuwave\Lighthouse\Validation\Validator;

final class UserResetPasswordValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'password' => ['required','confirmed','min:8'],
            'token' => ['required',function($value,$attribute,$fail){
                if ( $this->arg('token') ) {
                    $checkUserToken = DB::table('password_resets')->where([
                        'token' => $this->arg('token'),
                        'email' => $this->arg('email')
                    ])->count();

                    if ( ! $checkUserToken ) {
                        return $fail("Error Occure: Token corrupted");
                    }

                } else {
                    return $fail("Error Occure: Token doesn't exist");
                }
            }]
        ];
    }

    public function messages(): array
    {
        return [
            'password.min' => 'You must use at least 8 character for your password',
            'password.confirmed' => 'Password confirmation failed'
        ];
    }
}
