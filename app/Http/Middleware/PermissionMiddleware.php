<?php



namespace App\Http\Middleware;



use Closure;
use Illuminate\Http\Request;



class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // dd(getRouteMid());
        // hasAnyPermission
        // dd($request->route()->getName());
        if (\Auth::check() && ($request->route()->getName() != 'logout')) {
            if (\Auth::check()) {
                if (!auth()->user()->hasAnyPermission(getRouteMid())) {
                    abort(403);
                }
            }
        }
        return $next($request);
    }
}
