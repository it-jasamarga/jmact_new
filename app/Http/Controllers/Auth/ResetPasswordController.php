<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Auth;
use DB;
use Hash;
class ResetPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.reset');
    }

    public function store()
    {
        $userCheck = User::where('email', request()->email)->first();
        request()->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);

        $updatePassword = DB::table('password_resets')->where([
            'email' => request()->email, 
            'token' => request()->token
        ])->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Your Time Is Up');
        }

        $user = User::where('email', request()->email)->update(['password' => Hash::make(request()->password)]);

        DB::table('password_resets')->where(['email'=> request()->email])->delete();
        return redirect()->route('login')->with('message', 'Succesfuly Reset Password, Please Login Now');
    }
}
