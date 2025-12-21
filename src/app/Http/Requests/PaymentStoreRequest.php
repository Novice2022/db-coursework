<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:0.01'],
            'datetime' => ['nullable', 'date'],
        ];
    }
    
    public function messages(): array
    {
        return [
            'amount.required' => 'Сумма платежа обязательна',
            'amount.numeric' => 'Сумма должна быть числом',
            'amount.min' => 'Сумма должна быть больше 0',
        ];
    }
}