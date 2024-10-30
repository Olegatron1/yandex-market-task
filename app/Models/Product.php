<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
	protected $guarded = false;

	public $timestamps = false;

	public function stocks(): HasMany
	{
		return $this->hasMany(Stock::class);
	}

	public function orderItems(): HasMany
	{
		return $this->hasMany(OrderItem::class);
	}

	public function warehouses(): BelongsToMany
	{
		return $this->belongsToMany(Warehouse::class, 'stocks');
	}
}
