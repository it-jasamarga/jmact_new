<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfilRequest extends FormRequest
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
      $unique = ($id = request()->get('id')) ? ','.$id : '';
      return [
        'registered_village_id' => 'required',
        'name' => 'required|max:200|min:3',
        'gender' => 'required|max:200',
        'birthday' => 'required|date|max:200',
        'birthplace' => 'required|max:200',
        'identity_number' => 'required|min:16|max:16',
        'no_kk' => 'required|min:16|max:16',
      ];
    }
  }
