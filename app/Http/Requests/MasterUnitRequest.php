<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterUnitRequest extends FormRequest
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
      $unique = ($id = request()->route('unit')) ? ','.$id : '';
      return [
        'code' => 'required|string|max:255|min:1|unique:master_unit,code'.$unique,
        'unit' => 'required|string|min:1|max:255'
      ];
    }
  }
