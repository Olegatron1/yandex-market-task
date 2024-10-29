<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
	protected $guarded = false;

	public function stocks(): HasMany
	{
		return $this->hasMany(Stock::class);
	}

	public function orderItems(): HasMany
	{
		return $this->hasMany(OrderItem::class);
	}
}
