<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    protected $guarded = false;

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function warehouse(): BelongsTo
	{
		return $this->belongsTo(Warehouse::class);
	}

	public function order(): BelongsTo
	{
		return $this->belongsTo(Order::class);
	}
}
