<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\RegisteredVillage;
use Illuminate\Support\Facades\Storage;

class CreatorResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request $request
   * @return array
   */
  public function toArray($request)
  {
    $avatar = null;
    if($this->profile != null){
      $avatar = isset($this->profile->avatar) ? \Helper::exist(asset('storage/'.$this->profile->avatar)) : null;
    }
    return [
      'id' => $this->id,
      'name' => $this->name,
      'identity_number' => $this->identity_number,
      'phone_number' => ($this->profile) ? $this->profile->phone_number : null,
      'avatar' => $avatar,
      'gender' => $this->gender,
      'is_head_village' => $this->is_head_village,
      'resident_status' => $this->resident_status,
      'type_register' => $this->type_register,
      'typeApp' => isset($this->typeApp) ? MasterTypeAppResource::make($this->typeApp) : null,
    ];
  }
}
