<?php

namespace App\GraphQL\Validators;

use App\Models\Request;
use App\Models\RequestType;
use Exception;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Validation\Validator;

final class RequestInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'type' => ['required',function($attribute,$value,$fail){
                $is_type_exist = RequestType::where('id',$value)->count();
                if ( ! $is_type_exist ) {
                    throw new Exception("System failer occure please contact the system main support");
                }
            }],

            'name' => ['required','min:3',function($attribute,$value,$fail){
                $is_name_used = Request::where('name',$value)->where('company_id',Auth::user()->company_id)->count();

                if ( $is_name_used ) {
                    return $fail("This name is already used before");
                }
            }]
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Please add type to the request',
            'name.required' => 'Please enter request name',
            'name.min' => 'Request name must be at least 3 character'
        ];
    }
}
