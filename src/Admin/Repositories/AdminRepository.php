<?php

namespace BOK\Admin\Repositories;

use BOK\Admin\Admin;
use Jsdecena\Baserepo\BaseRepository;
use Illuminate\Database\QueryException;
use BOK\Admin\Exceptions\CreateAdminErrorException;
use BOK\Admin\Exceptions\UpdateAdminErrorException;
use BOK\Admin\Exceptions\AdminNotFoundErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminRepository extends BaseRepository
{
    /**
     * AdminRepository constructor.
     * @param  Admin  $admin
     */
    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
        $this->model = $admin;
    }

    public function updateAdmin(array $data): bool
    {
        try {
            return $this->model->update($data);
        } catch (QueryException $e) {
            throw new UpdateAdminErrorException($e);
        }
    }
    /**
     * @param  array  $data
     * @return mixed
     * @throws CreateAdminErrorException
     */
    public function createAdmin(array $data): Admin
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new CreateAdminErrorException ($e);
        }
    }

    public function findAdminById($id): Admin
    {
        try {
            return $this->model->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new AdminNotFoundErrorException ($e);
        }
    }
}
