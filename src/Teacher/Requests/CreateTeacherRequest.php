<?php


namespace BOK\Teacher\Requests;


use BOK\Teacher\Teacher;
use BOK\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class CreateTeacherRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email', 'unique:teachers'],
            'subject' => ['required', Rule::in(Teacher::SUBJECTS)]
        ];
    }
}
