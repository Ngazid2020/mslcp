<?php
namespace App\Filament\Resources\ElementResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Element;

/**
 * @property Element $resource
 */
class ElementTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
