<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      $unique = ($id = request()->route('user')) ? ','.$id : '';
      return [
        'name' => 'required|string|max:255|min:3',
        'email' => 'required|string|email|max:255|unique:users,email'.$unique,
        'password' => 'required|string|min:8|confirmed',
      ];
    }
  }
