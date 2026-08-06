<?php

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

class SubmitTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'citizen';
    }

    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:'.Service::class.',id'],
            'notes' => ['nullable', 'string'],
            'attachments' => ['required', 'array'],
            'attachments.*' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'service_id' => 'نوع الخدمة',
            'notes' => 'الملاحظات',
            'attachments' => 'المرفقات',
        ];
    }
}
