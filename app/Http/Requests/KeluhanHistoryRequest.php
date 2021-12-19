<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeluhanHistoryRequest extends FormRequest
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
      $unique = ($id = request()->route('keluhan_history')) ? ','.$id : '';
      return [
        'ruas_id' => 'required|string',
        'provider' => 'required|string|min:1|max:255'
      ];
    }
  }
