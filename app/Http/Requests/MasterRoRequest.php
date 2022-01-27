<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterRoRequest extends FormRequest
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
      $unique = ($id = request()->route('master_ro')) ? ','.$id : '';
      return [
        'name' => 'required|string|max:255|min:1|unique:master_ro,name'.$unique,
        // 'name' => 'required|string|max:255|min:1',
        'regional_id' => 'required'
      ];
    }
  }
