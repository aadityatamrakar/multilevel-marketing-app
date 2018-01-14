<?php

namespace App\Http\Middleware;

use Closure;

class MemberMiddleware
{
    public function __construct()
    {
        $this->auth = isset($_SESSION['role'])?$_SESSION['role']:null;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth !== 'member' && $this->auth !== 'admin') {
            return response('Unauthorized. <a href="/login">Login here</a>', 401);
        }

        return $next($request);
    }
}
