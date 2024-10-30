<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService
{
	public function IndexOrders(array $filters): LengthAwarePaginator
	{
		$query = Order::query()->with(['warehouse', 'orderItems.product']);

		if (!empty($filters['status'])) {
			$query->where('status', $filters['status']);
		}

		if (!empty($filters['warehouse_id'])) {
			$query->where('warehouse_id', $filters['warehouse_id']);
		}

		if (!empty($filters['date_from'])) {
			$query->whereDate('created_at', '>=', $filters['date_from']);
		}

		if (!empty($filters['date_to'])) {
			$query->whereDate('created_at', '<=', $filters['date_to']);
		}

		$perPage = $filters['per_page'] ?? 10;
		return $query->paginate($perPage);
	}

	public function createOrder(array $orderData): Order
	{
		return DB::transaction(function () use ($orderData) {
			$order = Order::create([
				'customer' => $orderData['customer'],
				'warehouse_id' => $orderData['warehouse_id'],
				'status' => 'active',
			]);

			foreach ($orderData['items'] as $item) {
				$stock = Stock::where('product_id', $item['product_id'])
					->where('warehouse_id', $orderData['warehouse_id'])
					->first();

				if (!$stock || $stock->stock < $item['count']) {
					throw new \Exception('Insufficient stock for product ID ' . $item['product_id']);
				}

				OrderItem::create([
					'order_id' => $order->id,
					'product_id' => $item['product_id'],
					'count' => $item['count'],
				]);

				$stock->decrement('stock', $item['count']);
			}

			return $order;
		});
	}

	public function updateOrder(Order $order, array $orderData, array $orderItems): Order
	{
		$order->update($orderData);

		$order->orderItems()->delete();
		$order->orderItems()->createMany($orderItems);

		return $order->load('items');
	}

	public function completeOrder(Order $order): JsonResponse
	{
		if ($order->status === 'active') {
			$order->update(['status' => 'completed']);

			foreach ($order->orderItems as $item) {
				StockMovement::create([
					'product_id' => $item->product_id,
					'warehouse_id' => $order->warehouse_id,
					'quantity' => $item->count,
					'action' => 'remove',
					'order_id' => $order->id,
				]);
			}

			return response()->json(['message' => 'Order completed successfully']);
		}

		return response()->json(['message' => 'Order is already completed or canceled'], 400);
	}

	public function cancelOrder(Order $order): JsonResponse
	{
		if ($order->status === 'active') {
			foreach ($order->orderItems as $item) {
				$stock = Stock::where('product_id', $item->product_id)
					->where('warehouse_id', $order->warehouse_id)
					->first();

				$stock->increment('stock', $item->count);

				StockMovement::create([
					'product_id' => $item->product_id,
					'warehouse_id' => $order->warehouse_id,
					'quantity' => $item->count,
					'action' => 'add',
					'order_id' => $order->id,
				]);
			}

			$order->update(['status' => 'canceled']);
			return response()->json(['message' => 'Order canceled successfully']);
		}

		return response()->json(['message' => 'Order cannot be canceled as it is completed or already canceled'], 400);
	}

	public function resumeOrder(Order $order): JsonResponse
	{
		if ($order->status === 'canceled') {
			foreach ($order->orderItems as $item) {
				$stock = Stock::where('product_id', $item->product_id)
					->where('warehouse_id', $order->warehouse_id)
					->first();

				if ($stock->stock < $item->count) {
					return response()->json(['message' => 'Not enough stock for product ID ' . $item->product_id], 400);
				}

				$stock->decrement('stock', $item->count);

				StockMovement::create([
					'product_id' => $item->product_id,
					'warehouse_id' => $order->warehouse_id,
					'quantity' => -$item->count,
					'action' => 'remove',
					'order_id' => $order->id,
				]);
			}

			$order->update(['status' => 'active']);
			return response()->json(['message' => 'Order resumed successfully']);
		}

		return response()->json(['message' => 'Order cannot be resumed as it is not in canceled state'], 400);
	}
}
