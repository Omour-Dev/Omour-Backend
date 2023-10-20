<?php

namespace Modules\Variation\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'title'            => $this->translate(locale())->title,
            'option_values'    => OptionValueResource::collection($this->values),
       ];
    }
}
