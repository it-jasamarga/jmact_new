<?php

namespace App\Extensions;

// use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        // dd('retrieveById', $identifier);
        $user = \App\Models\User::find($identifier);
        return $user;
    }

    public function retrieveByToken($identifier, $token)
    {
        // dd('retrieveByToken', $identifier, $token);
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // dd('updateRememberToken', $user, $token);
    }

    public function retrieveByCredentials(array $credentials)
    {
        Request()->session()->put('adr:auth-method', '');
        $user = \App\Models\User::where('npp', $credentials['username'])->first();
        if ($user) Request()->session()->put('adr:auth-method', 'npp');
        else {
            $user = \App\Models\User::where('username', $credentials['username'])->first();
            if ($user) Request()->session()->put('adr:auth-method', 'username');
        }
        // dd('retrieveByCredentials', $credentials, $user);
        return $user;
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // dd('validateCredentials', $user, $credentials, Request()->session()->get('adr:auth-method'));
        $auth = false;

        if (! array_key_exists('password', $credentials)) {
            return false;
        }
        
        if (Request()->session()->get('adr:auth-method') == 'npp') {
            $url = env('JMCLICK_AUTH_LOGIN', false);
            if ($url) {
                $response = Http::withOptions(['debug' => false, 'verify' => false ])->post($url, $credentials);
                $auth = $response->successful();
            }
        }
        
        if (Request()->session()->get('adr:auth-method') == 'username') {
            $user = \App\Models\User::where('username', $credentials['username'])->first();
            if ($user->active == 1) $auth = (Hash::check($credentials['password'], $user->password));
        }

        return $auth;
    }
}