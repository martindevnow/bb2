<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        $permitted_ips = [
            '192.168.222.1',
            '127.0.0.1',
            '10.0.2.15',
            '192.168.10.10'
        ];

        if (in_array(getenv('REMOTE_ADDR'), $permitted_ips))
            return $next($request);

        if ($request->user() == null)
            return redirect('home');

        if ( ! $request->user()->isAdmin()) {
            return redirect('home');
        }

        return $next($request);
    }
}
