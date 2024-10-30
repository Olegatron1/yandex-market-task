<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StockMovementController;
use App\Http\Controllers\Api\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Просмотреть список складов
Route::get('/warehouses', [WarehouseController::class, 'index']);

// Просмотреть список товаров с их остатками по складам
Route::get('/products', [ProductController::class, 'index']);

// Получить список заказов (с фильтрами и настраиваемой пагинацией)
Route::get('/orders', [OrderController::class, 'index']);

// Создать заказ (в заказе может быть несколько позиций с разным количеством)
Route::post('/orders', [OrderController::class, 'store']);

// Обновить заказ (данные покупателя и список позиций, но не статус)
Route::patch('/orders/{order}', [OrderController::class, 'update']);

// Завершить заказ
Route::patch('/orders/{order}/complete', [OrderController::class, 'complete']);

// Отменить заказ
Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel']);

// Возобновить заказ (перевод из отмены в работу)
Route::patch('/orders/{order}/resume', [OrderController::class, 'resume']);

// Таблица движений и модель для просмотра изменения остатков товаров
Route::get('/stock-movements', [StockMovementController::class, 'index']);
