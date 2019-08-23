<?php


namespace BOK\Http\Controllers\Auth;


use BOK\Admin\Admin;
use BOK\Http\Controllers\Controller;
use BOK\Auth\Repositories\AuthRepository;
use BOK\Admin\Repositories\AdminRepository;
use BOK\Auth\Requests\AuthenticationRequest;
use BOK\Admin\Transformers\AdminTransformer;

class AuthenticationApiController extends Controller
{
    /**
     * @var AdminRepository
     */
    private $adminRepo;
    /**
     * @var AuthRepository
     */
    private $authRepo;

    public function __construct(
        AuthRepository $authRepo,
        AdminRepository $adminRepo
    )
    {
        $this->authRepo  = $authRepo;
        $this->adminRepo = $adminRepo;
    }

    public function store(AuthenticationRequest $request)
    {
        switch ($request->input('type')) {
            case Admin::RESOURCE_KEY:
                $attempt = auth('admins')->attempt($request->only('email', 'password'));

                if (!$attempt) {
                    return response()->json(trans('errors.login'), 401);
                }

                $admin = $this->adminRepo->findAdminByEmail($request->input('email'));

                $data = $this->adminRepo->processItemTransformer(
                    $admin,
                    new AdminTransformer,
                    Admin::RESOURCE_KEY,
                    Admin::INCLUDES
                );

                $token = $this->authRepo->generateToken(
                    $admin->id,
                    config('bok.subject'),
                    Admin::RESOURCE_KEY,
                    config('bok.secret'),
                    config('bok.expiry')
                );

                $merged = collect($data->toArray())->merge([
                    'token' => (string)$token
                ]);

                return response()->json($merged);
                break;
        }
    }
}
