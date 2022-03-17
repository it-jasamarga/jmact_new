<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailReportRequest extends FormRequest
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
      $unique = ($id = request()->route('detail_report')) ? ','.$id : '';
      return [
        'url_file' => 'required|max:500000',
        'keterangan' => 'required|max:10000'
      ];
    }
  }
