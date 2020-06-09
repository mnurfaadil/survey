<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'header' => $this->header,
            'header_original_name' => $this->header_original_name,
            'footer' => $this->footer,
            'footer_original_name' => $this->footer_original_name,
        ];
    }
}
