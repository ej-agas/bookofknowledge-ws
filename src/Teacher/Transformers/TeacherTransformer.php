<?php


namespace BOK\Teacher\Transformers;


use BOK\Teacher\Teacher;
use League\Fractal\TransformerAbstract;

class TeacherTransformer extends TransformerAbstract
{
    public function transform(Teacher $teacher): array
    {
        return [
            'id' => $teacher->id,
            'first_name' => $teacher->first_name,
            'middle_name' => $teacher->middle_name,
            'last_name' => $teacher->last_name,
            'email' => $teacher->email,
            'full_name' => $teacher->full_name,
            'subject' => $teacher->subject
        ];
    }
}
