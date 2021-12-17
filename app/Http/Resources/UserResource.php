<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $village = [
          'id' => ($this->registerVillage) ? $this->registerVillage->id : null,
          'name' => ($this->registerVillage) ? $this->registerVillage->village->name : null,
          'logo' => ($this->registerVillage) ? \Helper::exist(asset('storage/'.$this->registerVillage->village->logo)) : null,
        ];

        $checkPassword = (Hash::check($this->password_old, $this->password)) ? true : false;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'identity_number' => $this->identity_number,
            'family_identity_number' => $this->family_identity_number,
            'is_online' => $this->is_online,
            'socket_id' => $this->socket_id,
            'actived' => $this->when($this->actived == 0,false,true),
            'active_balances' => $this->active_balances,
            'check_password' => $checkPassword,
            'email' => $this->email,
            'gender' => $this->gender,
            'balance' => isset($this->balance) ? $this->balance->sum('amount') : 0,
            'target_type' => 'User',
            'created_at' => \Carbon\Carbon::parse($this->created_at)->translatedFormat('l, d F Y H:i'),
            'profile' => isset($this->profile) ? ProfileResource::make($this->profile) : null,
            'is_merchant' => ($this->merchant) ? true : false,
            'resident_status' => $this->resident_status,
            'type_register' => $this->type_register,
            'account' => isset($this->norek) ? UserAccountResource::make($this->norek) : null,
            'status_pin_balances' => $this->status_pin_balances,
            'is_head_village' => $this->is_head_village,

            'province' => \Helper::codeProvince(),
            'citie' => \Helper::codeCity(),
            'district' => \Helper::codeDistrict(),
            'village' => $village,
            'typeApp' => isset($this->typeApp) ? MasterTypeAppResource::make($this->typeApp) : null,
            
        ];
    }
}
