<?php

namespace AccessManager\Prepaid\Http\Requests;


use AccessManager\Base\Http\Requests\BaseFormRequest;

class RechargeAccountRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'plan_id'   =>  ['required'],
            'username'  =>  ['required'],
        ];
    }
}