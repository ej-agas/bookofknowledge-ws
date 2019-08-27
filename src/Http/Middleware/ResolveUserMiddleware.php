<?php


namespace BOK\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;

class ResolveUserMiddleware
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->bearerToken()) {
            $token = (new Parser())->parse((string)$request->bearerToken());

            if ($token->hasClaim('user_type')) {
                $request->headers->set('user-type', $token->getClaim('user_type'));
            }
        }
        return $next($request);
    }
}
