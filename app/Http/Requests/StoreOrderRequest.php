<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'client_id.required' => 'El cliente es obligatorio',
            'client_id.exists' => 'El cliente no existe',
            'shipping_address.required' => 'La dirección de envío es obligatoria',
            'billing_address.required' => 'La dirección de facturación es obligatoria',
            'items.required' => 'Debe agregar al menos un producto',
            'items.*.product_id.required' => 'El producto es obligatorio',
            'items.*.product_id.exists' => 'El producto no existe',
            'items.*.quantity.required' => 'La cantidad es obligatoria',
            'items.*.quantity.integer' => 'La cantidad debe ser un número entero',
            'items.*.quantity.min' => 'La cantidad mínima es 1',
        ];
    }
}
