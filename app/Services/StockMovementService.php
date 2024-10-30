<?php

namespace App\Services;

use App\Models\StockMovement;
use Illuminate\Pagination\LengthAwarePaginator;

class StockMovementService
{
	public function getMovements(int $perPage): LengthAwarePaginator
	{
		return StockMovement::with(['product', 'warehouse', 'order'])
			->paginate($perPage);
	}

}