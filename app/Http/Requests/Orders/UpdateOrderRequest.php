<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;


class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('order'));
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => 'sometimes|string|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'payment_status' => 'sometimes|string|in:pending,paid,failed,refunded',
            'payment_method' => 'nullable|string|in:cash,card,bank_transfer',
            'delivery_address' => 'sometimes|required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'items' => 'sometimes|array|min:1',
            'items.*.book_id' => 'required_with:items|exists:books,id',
            'items.*.quantity' => 'required_with:items|integer|min:1|max:100',
            'items.*.unit_price' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'status.in' => 'Invalid order status.',
            'payment_status.in' => 'Invalid payment status.',
            'items.*.book_id.exists' => 'The selected book does not exist.',
        ];
    }
}
