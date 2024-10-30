<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Warehouse extends Model
{
    protected $guarded = false;

	public $timestamps = false;

	public function orders(): HasMany
	{
		return $this->hasMany(Order::class);
	}

	public function order(): HasOne
	{
		return $this->hasOne(Order::class);
	}

	public function stocks(): HasMany
	{
		return $this->hasMany(Stock::class);
	}

	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class, 'stocks');
	}

}
