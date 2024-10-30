<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\IndexRequest;
use App\Http\Requests\Api\Order\StoreRequest;
use App\Http\Requests\Api\Order\UpdateRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
	protected OrderService $orderService;

	public function __construct(OrderService $orderService)
	{
		$this->orderService = $orderService;
	}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): JsonResponse
	{
        $filters = $request->validated();
		$orders = $this->orderService->IndexOrders($filters);

		return response()->json(OrderResource::collection($orders));
	}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): JsonResponse
	{
		try {
			$order = $this->orderService->createOrder($request->validated());

			return response()->json([
				'message' => 'Order created successfully',
				'order' => $order->load('orderItems.product'),
			], 201);
		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 400);
		}
    }

    /**
     * Update the specified resource in storage.
     */
	public function update(UpdateRequest $request, Order $order): JsonResponse
	{
		$updatedOrder = $this->orderService->updateOrder(
			$order,
			$request->only(['customer', 'warehouse_id']),
			$request->input('items')
		);

		return response()->json(['message' => 'Order updated successfully', 'order' => $updatedOrder]);
	}

	public function complete(Order $order): JsonResponse
	{
		return $this->orderService->completeOrder($order);
	}

	public function cancel(Order $order): JsonResponse
	{
		return $this->orderService->cancelOrder($order);
	}

	public function resume(Order $order): JsonResponse
	{
		return $this->orderService->resumeOrder($order);
	}
}
