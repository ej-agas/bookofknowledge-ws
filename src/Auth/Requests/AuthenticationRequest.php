<?php


namespace BOK\Auth\Requests;


use BOK\Admin\Admin;
use BOK\Teacher\Teacher;
use BOK\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class AuthenticationRequest extends BaseFormRequest
{
    public function rules(): array
    {
        $subjects = [
            Admin::RESOURCE_KEY,
            Teacher::RESOURCE_KEY
        ];

        return [
            'subject' => ['required', Rule::in($subjects)]
        ];
    }
}
