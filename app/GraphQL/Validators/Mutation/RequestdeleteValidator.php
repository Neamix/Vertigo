<?php

namespace App\GraphQL\Validators\Mutation;

use App\Models\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Validation\Validator;

final class RequestdeleteValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'id' => ['exists:requests,id'],
            'password' => ['required',
                function($attribute,$value,$fail) {
                    if ( ! Hash::check($value,Auth::user()->password) ) {
                        return $fail('Wrong password,please check your password and try again');
                    }
                }
            ],
        ];
    }
}
