<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login()
    {
        request()->validate([
            'username' => 'required|max:150',
            'password' => 'required',
        ]);

        $auth = Auth::attempt(request(['username', 'password']));

        // dd($auth);

        if ($auth) {
            return redirect('/');
        }else{

            // $users = DB::table('users')->where('username', request()->username)->first();

            $message = ['username' => 'The username or password is not valid'];
            return redirect()->back()->withInput()->withErrors($message);
        }

        // $users = DB::table('users')->where('username', request()->username)->first();
        
        // if($users){
        //     if ($users->active == 1) {
        //         $auth = Auth::attempt(request(['username', 'password']));
        //         if (!$auth) {
        //             $message = ['password' => 'The password is not valid'];
        //             return redirect()->back()->withInput()->withErrors($message);
        //         }
                
        //         return redirect('/');
                
        //     }else{
        //         $message = ['message' => 'The credential is not valid, please contact administrator'];
        //         return redirect()->back()->withInput()->withErrors($message);
        //     }
        // }else{
        //     $message = ['username' => 'The username is not valid'];
        //     return redirect()->back()->withInput()->withErrors($message);
        // }

    }

    public function logout()
    {
       Auth::logout();
       return redirect('/');
    }

   
}
