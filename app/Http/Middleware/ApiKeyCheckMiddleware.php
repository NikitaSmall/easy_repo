<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\ApiKey;

class ApiKeyCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = $request->apiKey;

        if ($user = ApiKey::check($key)) {
          Auth::login($user);
          return $next($request);
        }

        abort(401, 'Unauthorized action.');
    }
}
