<?php

namespace App\GraphQL\Validators;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Validation\Validator;

final class UserCreateInputValidator extends Validator
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
                $user_exist = User::where('email',$this->arg('email'));
                
                if ( $this->arg('id') ) {
                    $user_exist->where('id','<>',$this->arg('id'));
                }

                if ( $user_exist->count() ) {
                    return $fail('This email is already exist');
                }
            }],
            'name' => ['required','min:4'],
            'role' => ['required','exists:roles,id',function ($attribute,$value,$fail) {
                $checkRoleBelongToUserCompany = Role::where([
                    'id' => $value,
                    'company_id' => Auth::user()->company_id
                ])->count();

                if ( ! $checkRoleBelongToUserCompany ) {
                    return $fail('Please enter valid role');
                }
            }]
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required',
            'name.required'  => 'You have to add name for this college',
            'name.min' => 'The name of college be at least 4 character',
            'role.required' => 'Please enter college role',
            'role.exists' => 'Please enter valid role'
        ];
    }
}
