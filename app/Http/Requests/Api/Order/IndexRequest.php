<?php

namespace App\Http\Requests\Api\Order;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'nullable|string|in:active,canceled,completed',
			'warehouse_id' => 'nullable|integer',
			'date_from' => 'nullable|date',
			'date_to' => 'nullable|date',
			'per_page' => 'nullable|integer|min:1',
        ];
    }
}
