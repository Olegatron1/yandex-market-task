<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
    protected $guarded = false;

	public function warehouses(): BelongsToMany
	{
		return $this->belongsToMany(Warehouse::class);
	}

	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class);
	}
}
