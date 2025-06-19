<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
		if (Auth::guard($guard)->check()) {
			if ($request->user()->role_users_id == 1)
			{
				return redirect('/admin/dashboard');
			}
			elseif ($request->user()->role_users_id == 2)
			{
				return redirect('/employee/dashboard');
			}
			else
			{
				return redirect('/client/dashboard');
			}
		}
		return $next($request);
    }
}
