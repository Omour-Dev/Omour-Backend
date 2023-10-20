<?php

namespace Modules\Notification\Transformers\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type'         => $this->data['type'],
            'title'        => $this->data['title'][locale()],
            'description'  => $this->data['description'][locale()],
            'read_at'      => $this->read_at
        ];
    }
}
