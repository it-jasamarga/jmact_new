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
      $unique = ($id = request()->route('master_bk')) ? ','.$id : '';
      return [
        'bidang' => 'required|string|max:255|min:1',
        'keluhan' => 'required|string|max:255',
        'tipe_layanan_keluhan' => 'required|string|max:255',
        'unit_id' => 'required',
        'sla' => 'required',
        'active' => 'required'
      ];
    }
  }
