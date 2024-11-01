<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderItem extends Model
{
	protected $guarded = false;

	public $timestamps = false;

	public function orders(): BelongsToMany
	{
		return $this->belongsToMany(Order::class);
	}

	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class);
	}

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}
}
