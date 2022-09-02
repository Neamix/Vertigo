<?php

namespace App\GraphQL\Validators;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Validation\Validator;
use PHPUnit\Framework\Constraint\Count;

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
            'email' => ['required','email',function($attribute,$value,$fail){

                $user = User::where('email',$value)->first();

                if ( ! $user ) {
                    return $fail('Wrong credintions please check your email and password');
                }

                $checkPassword = password_verify($this->arg('password'),$user->password);

                if ( ! $checkPassword ) {
                    return $fail('Wrong credintions please check your email and password');
                }

                if ( ! $user->active ) {
                    return $fail('Your account has been suspended please contact your company support');
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
