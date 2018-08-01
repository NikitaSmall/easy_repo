<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use App\ApiKey;
use App\Log;
use DB;

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
        $limit = 3;
        $key = $request->apiKey;

        if ($user = ApiKey::check($key)) {
          Auth::login($user);
          $count = DB::select('SELECT count(id) as amount
                               FROM `logs`
                               WHERE user_id = ?
                                 AND created_at > DATE_SUB(UTC_TIMESTAMP(), INTERVAL 1 HOUR)',
                               [$user->id]);

          if ($count[0]->amount > $limit) {
            abort(403, 'The limit is reached.');
          }
          Log::create(['user_id' => $user->id, 'path' => $request->fullUrl()]);
          return $next($request);
        }

        abort(401, 'Unauthorized action.');
    }
}
