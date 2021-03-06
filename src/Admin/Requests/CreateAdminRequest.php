<?php


namespace BOK\Admin\Requests;

use BOK\Base\BaseFormRequest;

class CreateAdminRequest extends BaseFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', 'min:6'],
        ];
    }
}
