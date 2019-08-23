<?php


namespace BOK\Http\Middleware;


use Closure;
use Carbon\Carbon;
use Lcobucci\JWT\Parser;
use Illuminate\Http\Request;
use Lcobucci\JWT\ValidationData;
use BOK\Auth\Repositories\AuthRepository;

class JwtParserMiddleware
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            abort(401, 'No Bearer Token.');
        }

        $token = (new Parser())->parse((string)$request->bearerToken());

        $validate = new ValidationData;
        $validate->setSubject(config('bok.subject'));

        $authRepo = new AuthRepository;
        $user = $authRepo->parseUser($token->getClaim('user_type'), $token->getClaim('jti'));

        $validate->setId($user->id);

        $time = Carbon::createFromTimeStamp($token->getClaim('exp'));

        if (!$token->validate($validate) && $time->lessThan(Carbon::now())) {
            abort(401, 'Token has expired or invalid.');
        }

        $response = next($request);
        $content = json_decode($response->content(), true);

        $append = array_merge(
            $content,
            [
                'jsonapi' => [
                    'version' => '1.0',
                    'url' => 'https://jsonapi.org'
                ]
            ]
        );

        $response->setContent(json_encode($append));

        return $response;
    }
}
