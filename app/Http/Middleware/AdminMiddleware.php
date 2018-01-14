<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
{
    public function __construct()
    {
        $this->auth = isset($_SESSION['role'])?$_SESSION['role']:null;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth !== 'admin') {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
