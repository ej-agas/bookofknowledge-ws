<?php


namespace BOK\Http\Controllers\Admin;


use BOK\Admin\Admin;
use Illuminate\Http\JsonResponse;
use BOK\Http\Controllers\Controller;
use BOK\Admin\Requests\CreateAdminRequest;
use BOK\Admin\Requests\UpdateAdminRequest;
use BOK\Admin\Repositories\AdminRepository;
use BOK\Admin\Transformers\AdminTransformer;
use BOK\Admin\Exceptions\CreateAdminErrorException;
use BOK\Admin\Exceptions\UpdateAdminErrorException;
use BOK\Admin\Exceptions\AdminNotFoundErrorException;

class AdminApiController extends Controller
{
    private $adminRepo;

    /**
     * AdminApiController constructor.
     * @param  AdminRepository  $adminRepo
     */
    public function __construct(
        AdminRepository $adminRepo
    )
    {
        $this->adminRepo = $adminRepo;
    }

    /**
     * @param $adminId
     * @return JsonResponse
     */
    public function show($adminId): JsonResponse
    {
        try {
            $admin = $this->adminRepo->findAdminById($adminId);

            $data = $this->adminRepo->processItemTransformer(
                $admin,
                new AdminTransformer,
                Admin::RESOURCE_KEY,
                Admin::INCLUDES
            );

            return response()->json($data->toArray());
        } catch (AdminNotFoundErrorException $e) {
            return response()->json(trans('errors.not_found'), 404);
        }
    }
    /**
     * @param  CreateAdminRequest  $request
     * @return JsonResponse
     */
    public function store(CreateAdminRequest $request): JsonResponse
    {
        try {
            $admin = $this->adminRepo->createAdmin($request->only(Admin::FILLABLES));
            $data = $this->adminRepo->processItemTransformer(
                $admin,
                new AdminTransformer,
                Admin::RESOURCE_KEY,
                Admin::INCLUDES
            );

            return response()->json($data->toArray(), 201);
        } catch (CreateAdminErrorException $e) {
            return response()->json(trans('errors.create'), 400);
        }
    }

    /**
     * @param  $adminId
     * @param  UpdateAdminRequest  $request
     * @return JsonResponse
     */
    public function update($adminId, UpdateAdminRequest $request): JsonResponse
    {
        try {
            $admin = $this->adminRepo->findAdminById($adminId);

            $adminRepo = new AdminRepository($admin);
            $adminRepo->updateAdmin($request->only(Admin::FILLABLES));

            $data = $this->adminRepo->processItemTransformer(
                $admin,
                new AdminTransformer,
                Admin::RESOURCE_KEY,
                Admin::INCLUDES
            );

            return response()->json($data->toArray());
        } catch (AdminNotFoundErrorException $e) {
            return response()->json(trans('errors.not_found'), 404);
        } catch (UpdateAdminErrorException $e) {
            return response()->json(trans('errors.update'), 400);
        }
    }
}
