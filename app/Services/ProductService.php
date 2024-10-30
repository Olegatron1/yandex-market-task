<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
	public function getAllProducts(): Collection
	{
		return Product::with(['stocks' => function($stock) {
			$stock->with('warehouse');
		}])->get();
	}

}