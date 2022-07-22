<?php

namespace App\GraphQL\Validators;

use App\Models\User;
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
            'email' => ['required',function($value,$attribute,$fail){
                $user_exist = User::where('email',$this->arg('email'))->count();

                if ($user_exist) {
                    return $fail('This email is already exist');
                }
            }],
            'name' => ['required','min:4']
        ];
    }
}
