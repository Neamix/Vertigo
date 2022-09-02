<?php

namespace App\GraphQL\Validators\Mutation;

use App\Models\Role;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Nuwave\Lighthouse\Validation\Validator;

final class RoledeleteValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'id' => ['exists:roles,id',function($attribute,$value,$fail){
                $role = Role::find($value);
                $user_has_role = $role->users()->count();
                
                if ( $role->id == PARTNER || $role->id == SUPER_ADMIN ) {
                    throw new Exception("System failer occure please contact the system main support");
                }
                
                if ( $user_has_role ) {
                    return $fail("Howdy, There is users have this roles please remove the role from them to be able to delete it");
                }

               
            }],
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
