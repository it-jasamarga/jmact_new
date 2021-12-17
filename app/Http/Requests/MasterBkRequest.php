<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterBkRequest extends FormRequest
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
      $unique = ($id = request()->route('bidang_keluhan')) ? ','.$id : '';
      return [
        'bidang' => 'required|string|max:255|min:1|unique:master_bk,bidang'.$unique,
        'keluhan' => 'required|string|max:255'
      ];
    }
  }
