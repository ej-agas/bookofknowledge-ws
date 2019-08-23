<?php


namespace BOK\Auth\Requests;


use BOK\Admin\Admin;
use BOK\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class AuthenticationRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $types = [
            Admin::RESOURCE_KEY
        ];

        return [
            'type' => ['required', Rule::in($types)]
        ];
    }
}
