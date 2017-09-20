<?php

namespace AccessManager\Prepaid\Http\Requests;


use AccessManager\Base\Http\Requests\BaseFormRequest;

class GenerateVouchersRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'plan_id'               =>  ['required', 'exists:service_plans,id' ],
            'count'                 =>  ['required', 'integer', 'min:1', ],
            'validity'              =>  ['required', ],
            'validity_unit'         =>  ['required', ],
        ];
    }
}