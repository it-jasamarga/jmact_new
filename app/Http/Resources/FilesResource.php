<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FilesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'target_id' => $this->target_id,
            'target_type' => $this->target_type,
            'has_relation_id' => $this->has_relation_id,
            'has_relation_type' => $this->has_relation_type,
            'name' => $this->name,
            'extension' => $this->extension,
            'url' => isset($this->url) ? \Helper::exist(asset('storage/'.$this->url)) : asset('images/no-images.png'),
            'created_at' => Carbon::parse($this->created_at)
               ->translatedFormat('l, d F Y H:i'),
            'creator' => ($this->creator) ? CreatorResource::make($this->creator) : null,
            // 'actived' => $this->when($this->actived == 0,false,true),
        ];
          return $data;
    }
}
