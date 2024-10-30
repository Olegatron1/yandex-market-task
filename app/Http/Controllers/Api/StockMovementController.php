<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StockMovementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
	protected StockMovementService $stockMovementService;

	public function __construct(StockMovementService $stockMovementService)
	{
		$this->stockMovementService = $stockMovementService;
	}

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): JsonResponse
	{
		$perPage = $request->get('per_page', 10);
		$movements = $this->stockMovementService->getMovements($perPage);

		return response()->json($movements);
	}

}
