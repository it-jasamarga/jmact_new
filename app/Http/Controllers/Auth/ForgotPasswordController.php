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

class ForgotPasswordController extends Controller
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
        return view('auth.forgot');
    }

    public function store(){
        request()->validate([
            'email' => 'required|email|max:250',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => request()->email,
            'token' => $token,
            'created_at' => Carbon::now()

        ]);
        sendMail(
            'mail.mail-forgot',
            'Commic Zone - Forgot Password',
            request()->email,
            url('reset-password/' . $token . '?email=' . request()->email)
        );

        return back()->with('message', 'We have emailed your password reset link! ');
    }
}
