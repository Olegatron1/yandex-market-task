<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
			'name' => $this->name,
			'warehouses' => $this->stocks->map(function ($stock) {
				return [
					'name' => $stock->warehouse->name,
					'count' => $stock->stock,
				];
			})
		];
    }
}
