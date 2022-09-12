<?php

namespace App\GraphQL\Validators;

use App\Models\Status;
use App\Models\StatusType;
use Exception;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Validation\Validator;

final class StatusInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','min:3',function($attribute,$value,$fail){
                if ( $this->arg('id') ) {
                    $is_name_used = Status::where('name',$value)->where('company_id',Auth::user()->company_id)->where('id','!=',$this->arg('id'))->count();
                } else {
                    $is_name_used = Status::where('name',$value)->where('company_id',Auth::user()->company_id)->count();
                }

                if ( $is_name_used ) {
                    return $fail("This name is already used before");
                }
            }],
            'color' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'color.required' => 'Please add color to the status',
            'name.required' => 'Please enter status name',
            'name.min' => 'Status name must be at least 3 character'
        ];
    }
}
