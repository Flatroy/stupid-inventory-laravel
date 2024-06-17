<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Item */
class ItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'id' => $this->id,
            'ulid' => $this->ulid,
            'name' => $this->name,
            'description' => $this->description,
            'import_ref' => $this->import_ref,
            'notes' => $this->notes,
            'quantity' => $this->quantity,
            'insured' => $this->insured,
            'archived' => $this->archived,
            'asset_id' => $this->asset_id,
            'serial_number' => $this->serial_number,
            'model_number' => $this->model_number,
            'manufacturer' => $this->manufacturer,
            'lifetime_warranty' => $this->lifetime_warranty,
            'warranty_expires' => $this->warranty_expires,
            'warranty_details' => $this->warranty_details,
            'purchase_time' => $this->purchase_time,
            'purchase_from' => $this->purchase_from,
            'purchase_price' => $this->purchase_price,
            'sold_time' => $this->sold_time,
            'sold_to' => $this->sold_to,
            'sold_price' => $this->sold_price,
            'sold_notes' => $this->sold_notes,

            'location_id' => $this->location_id,

            'location' => new LocationResource($this->whenLoaded('location')),
        ];
    }
}
