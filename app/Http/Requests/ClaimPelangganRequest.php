<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaimPelangganRequest extends FormRequest
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
      $unique = ($id = request()->route('claim_pelanggan')) ? ','.$id : '';
      return [
        'nama_pelanggan' => 'required|string|min:1|max:255',
        'nik_pelanggan' => 'required|numeric|max:16',
        'alamat_pelanggan' => 'required|string|min:1|max:255',
        'kontak_pelanggan' => 'required|string|min:1|max:255',
        'lokasi_kejadian' => 'required|string|min:1|max:255',
        'jenis_kendaraan' => 'required|string|min:1|max:255',
        'tanggal_kejadian' => 'required|string|min:1|max:255|date_format:Y-m-d H:i:s',
        'keterangan_claim' => 'required|string|min:1|max:255',
        'no_polisi' => 'required|string|min:1|max:255',
        'nominal_customer' => 'required|numeric|min:1|digits_between:4,10',
        // 'nominal_final' => 'required|numeric|min:1|digits_between:8,14',
        // 'unit_id' => 'required|min:1|max:255',
        // 'regional_id' => 'required|min:1|max:255',
        // 'sumber_id' => 'required|min:1|max:255',
        'jenis_claim_id' => 'required|min:1|max:255',
        'ruas_id' => 'required|min:1|max:255',
        'golongan_id' => 'required|min:1|max:255'
      ];
    }
  }
