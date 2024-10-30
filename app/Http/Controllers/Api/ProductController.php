<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
	protected ProductService $productService;

	public function __construct(ProductService $productService)
	{
		$this->productService = $productService;
	}

    /**
     * Display a listing of the resource.
     */
	public function index(): AnonymousResourceCollection
	{
		$products = $this->productService->getAllProducts();

		return ProductResource::collection($products);
	}

}
