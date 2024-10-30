<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'customer' => 'required|string',
			'warehouse_id' => 'required|exists:warehouses,id',
			'items' => 'required|array',
			'items.*.product_id' => 'required|exists:products,id',
			'items.*.count' => 'required|integer|min:1',
        ];
    }
}
