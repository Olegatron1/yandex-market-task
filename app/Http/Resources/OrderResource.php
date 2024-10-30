<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			'id' => $this->id,
			'customer' => $this->customer,
			'status' => $this->status,
			'warehouse' => [
				'id' => $this->warehouse->id,
				'name' => $this->warehouse->name,
			],
			'order_items' => $this->orderItems->map(function ($item) {
				return [
					'product_id' => $item->product_id,
					'product_name' => $item->product->name,
					'count' => $item->count,
				];
			}),
			'created_at' => $this->created_at,
		];
    }
}
