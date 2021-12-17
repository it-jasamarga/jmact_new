<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterGolkenRequest extends FormRequest
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
      $unique = ($id = request()->route('golongan_kendaraan')) ? ','.$id : '';
      return [
        'golongan' => 'required|string|max:255|min:1|unique:master_golken,golongan'.$unique,
        'description' => 'max:5000',
      ];
    }
  }
