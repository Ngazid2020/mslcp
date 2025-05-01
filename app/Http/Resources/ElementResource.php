<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ElementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'nom'=>$this->id,
            'ref_inf_h'=>$this->ref_inf_h,
            'ref_sup_h'=>$this->ref_sup_h,
            'unite'=>$this->unite,
        ];
    }
}
