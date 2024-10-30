<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
	use HasFactory;

    protected $guarded = false;

	public $timestamps = false;

	public function warehouses(): BelongsToMany
	{
		return $this->belongsToMany(Warehouse::class);
	}

	public function products(): BelongsToMany
	{
		return $this->belongsToMany(Product::class);
	}

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function warehouse(): BelongsTo
	{
		return $this->belongsTo(Warehouse::class);
	}
}
