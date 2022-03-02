<?php

namespace App\Extensions;

use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        $user = (Request()->session()->get('adr:auth-method') == '') ? null : \App\Models\User::where(Request()->session()->get('adr:auth-method'), $identifier)->first(); 
        return $user;
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        //
    }

    public function retrieveByCredentials(array $credentials)
    {
        return new \App\Models\User([
            'id' => $credentials['username'],
            'email' => $credentials['username'],
        ]);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        $ret = false;
        Request()->session()->put('adr:auth-method', '');

        if (! array_key_exists('password', $credentials)) {
            return false;
        }

        $response = Http::withOptions(['debug' => false, 'verify' => false ])->post(env('JMCLICK_AUTH_LOGIN'), $credentials);

        if ($response->successful()) {
            Request()->session()->put('adr:auth-method', 'npp');
            $ret = true;
        } else {
            $user = \App\Models\User::where('username', $credentials['username'])->first();
            $auth = (Hash::check($credentials['password'], $user->password));
            if ($auth) {
                Request()->session()->put('adr:auth-method', 'username');
                $ret = true;
            }
        }
        return $ret;
    }
}