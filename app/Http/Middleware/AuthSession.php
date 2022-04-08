<?php



namespace App\Http\Middleware;



use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Throwable;

class AuthSession
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;



    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }



    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($request->is('admin/*'));
        if (!\Auth::check()) {
            if ($request->is('admin/*') && $request->ajax()) {
                return response()->json(['error' => 'Unauthenticated', 'code' => 401], 401);
            }
        }
        return $next($request);
    }
}
