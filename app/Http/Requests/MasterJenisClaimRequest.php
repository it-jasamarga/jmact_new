<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MasterJenisClaimRequest extends FormRequest
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
      $unique = ($id = request()->route('master_claim')) ? ','.$id : '';
      return [
        'code' => 'required|string|max:255|min:1|unique:master_jenis_claim,code'.$unique,
        // 'code' => 'required|string|max:255|min:1',
        'jenis_claim' => 'required|string|min:1|max:255'
      ];
    }
  }
