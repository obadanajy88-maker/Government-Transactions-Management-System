<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['employee', 'manager'], true);
    }

    public function rules(): array
    {
        $rules = [
            'action' => ['required', 'in:claim,accept,reject,transfer,complete'],
        ];

        if ($this->input('action') === 'reject') {
            $rules['reason'] = ['required', 'string', 'min:3'];
        }

        if ($this->input('action') === 'transfer') {
            $rules['reason'] = ['required', 'string', 'min:3'];
            $rules['transfer_to_user_id'] = ['required_without:department', 'nullable', 'exists:users,id'];
            $rules['department'] = ['required_without:transfer_to_user_id', 'nullable', 'string'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'action' => 'الإجراء',
            'reason' => 'سبب الرفض',
            'transfer_to_user_id' => 'الموظف المستهدف',
            'department' => 'القسم المستهدف',
        ];
    }
}
