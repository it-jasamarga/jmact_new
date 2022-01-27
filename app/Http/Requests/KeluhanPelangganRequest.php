<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeluhanPelangganRequest extends FormRequest
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
      $unique = ($id = request()->route('keluhan_pelanggan')) ? ','.$id : '';
      return [
        'nama_cust' => 'required|string|min:1|max:255',
        'no_telepon' => 'required|string|min:1|max:255',
        'lokasi_kejadian' => 'required|string|min:1|max:255',
        'tanggal_kejadian' => 'required|string|min:1|max:255|date_format:Y-m-d H:i:s',
        'keterangan_keluhan' => 'required|string|min:1|max:255',
        // 'unit_id' => 'required|min:1|max:255',
        // 'regional_id' => 'required|min:1|max:255',
        'sumber_id' => 'required|min:1|max:255',
        'bidang_id' => 'required|min:1|max:255',
        'ruas_id' => 'required|min:1|max:255',
        'golongan_id' => 'required|min:1|max:255'
      ];
    }
  }
