<?php


namespace BOK\Admin\Transformers;

use BOK\Admin\Admin;
use League\Fractal\TransformerAbstract;

class AdminTransformer extends TransformerAbstract
{
    public function transform(Admin $admin): array
    {
        return [
            'id' => $admin->id,
            'first_name' => $admin->first_name,
            'middle_name' => $admin->middle_name,
            'last_name' => $admin->last_name,
            'email' => $admin->email,
            'full_name' => $admin->full_name,
        ];
    }
}
