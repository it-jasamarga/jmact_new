<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterRuasRequest extends FormRequest
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
      $unique = ($id = request()->route('master_rua')) ? ','.$id : '';
      return [
        // 'name' => 'required|string|max:255|min:1|unique:master_ruas,name'.$unique,
        'name' => 'required|string|max:255|min:1',
        'ro_id' => 'required'
      ];
    }
  }
