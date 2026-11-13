<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'customer';
    }

    public function rules(): array
    {
        return [
            'recipient_name' => ['required', 'max:120'],
            'phone' => ['required', 'max:30'],
            'address' => ['required', 'string', 'max:1000'],
            'shipping_service_id' => ['required', 'exists:shipping_services,id'],
        ];
    }
}
