<?php


namespace BOK\Admin\Requests;


use BOK\Base\BaseFormRequest;

class UpdateAdminRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:admins'],
        ];
    }
}
