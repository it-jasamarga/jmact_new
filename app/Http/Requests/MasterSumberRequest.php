<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterSumberRequest extends FormRequest
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
      $unique = ($id = request()->route('master_sumber')) ? ','.$id : '';
      return [
        'code' => 'required|string|max:255|min:1|unique:master_sumber,code'.$unique,
        // 'code' => 'required|string|max:255|min:1',
        'keluhan' => 'boolean',
        'claim' => 'boolean',
        'description' => 'required|max:5000',
        'active' => 'required'
      ];
    }
  }
