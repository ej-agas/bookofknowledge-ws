<?php


namespace BOK\Auth\Repositories;


use BOK\Admin\Admin;
use Lcobucci\JWT\Token;
use BOK\Teacher\Teacher;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use BOK\Admin\Repositories\AdminRepository;
use BOK\Teacher\Repositories\TeacherRepository;
use BOK\Admin\Exceptions\AdminNotFoundErrorException;
use BOK\Teacher\Exceptions\TeacherNotFoundErrorException;

class AuthRepository
{
    /**
     * @param        $id
     * @param        $subject
     * @param        $type
     * @param        $secret
     * @param  int   $expiration
     * @param  null  $issuer
     * @param  null  $audience
     * @return Token
     */
    public function generateToken($id, $subject, $type, $secret ,int $expiration = 3600, $issuer = null, $audience = null): Token
    {
        $token = new Builder();

        if ($issuer) {
            $token->issuedBy($issuer);
        }

        if ($audience) {
            $token->permittedFor($audience);
        }

        if ($id) {
            $token->identifiedBy($id, true);
        }

        if ($subject) {
            $token->relatedTo($subject);
        }

        if ($type) {
            $token->withClaim('user_type', $type);
        }
        $token->issuedAt(time())->canOnlyBeUsedAfter(time())->expiresAt(time() + $expiration);

        return $token->getToken(new Sha256, new Key($secret));
    }

    public function parseUser(string $type, $id)
    {
        switch ($type) {
            case Admin::RESOURCE_KEY:
                try {
                    $adminRepo = new AdminRepository(new Admin);
                    $user = $adminRepo->findAdminById($id);

                    auth(Admin::RESOURCE_KEY)->login($user);

                    return $user;
                } catch (AdminNotFoundErrorException $e) {
                    abort(404);
                }
                break;
            case Teacher::RESOURCE_KEY:
                try {
                    $teacherRepo = new TeacherRepository(new Teacher);
                    $user = $teacherRepo->findTeacherById($id);

                    auth(Admin::RESOURCE_KEY)->login($user);
                } catch (TeacherNotFoundErrorException $e) {
                    abort(404);
                }
                break;
        }
    }
}
