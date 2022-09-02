<?php

namespace App\GraphQL\Validators;

use App\Models\Priviledge;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Validation\Validator;

final class RoleInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'id' => [function($attribute,$value,$fail){
               
                if ( $value ) {
                    $role = Role::find($value);
                
                    if ( ! $role ) {
                        return $fail("This role doesn't exist");
                    }
                }

            }],
            'priviledges' => [function($attribute,$value,$fail){

                $countPriviledges = Priviledge::whereIn('id',$value)->count();
                
                if ( $countPriviledges != count($value) ) {
                    return $fail("Some of this priviledges don't exist");
                }

            }],

            'name' => ['required_without:id',function($attribute,$value,$fail){
                if ( ! $this->arg('id') ) {
                    $countName = Role::where([
                        'name' => $value,
                        'company_id' => Auth::user()->company_id
                    ])->count();
                    
                    if ( $countName ) {
                        return $fail("This role name already in use");
                    }
                }
            }]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required_without' => "Please enter role name",
            'priviledges.required_without' => "Please enter at least one priviledge"
        ];
    }
}
