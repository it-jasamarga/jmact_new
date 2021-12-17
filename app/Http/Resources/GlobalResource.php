<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ArticleCategory;

class GlobalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->resource == 'create'){
            return [
                'status' => true,
                'message' => 'Saved Success',
            ];
        }elseif($this->resource == 'update'){
            return [
                'status' => true,
                'message' => 'Updated Success',
            ];
        }elseif($this->resource == 'delete'){
            return [
                'status' => true,
                'message' => 'Deleted Success',
            ];
        }
    }
}
