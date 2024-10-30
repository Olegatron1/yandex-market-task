<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
	{
        return Warehouse::all();
    }

}
