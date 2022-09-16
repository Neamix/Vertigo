<?php

namespace App\GraphQL\Validators;

use App\Models\Attending;
use Illuminate\Support\Facades\Auth;
use Nuwave\Lighthouse\Validation\Validator;

final class AttendingInputValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required',function ($attribute,$value,$fail) {
                if ( Auth::check() ) {
                    $attendingNameExist=  Attending::where('name',$value)->where('company_id',Auth::user()->id)->count();

                    if ( $attendingNameExist ) {
                        return $fail("You already have attending profile with same name,please use another name to prevent any conflict");
                    }
                }
            }],
        ];
    }
}
