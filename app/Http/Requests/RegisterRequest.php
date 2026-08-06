<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'national_id' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'phone_number' => ['required', 'string', 'max:20'],
            'role' => ['required', 'string', 'in:citizen,employee,manager'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::min(8)->letters()->numbers()->symbols()],
        ];
    }

    public function attributes(): array
    {
        return [
            'full_name' => 'الاسم الكامل',
            'email' => 'البريد الإلكتروني',
            'national_id' => 'الرقم الوطني',
            'phone_number' => 'رقم الهاتف',
            'role' => 'الدور',
            'password' => 'كلمة المرور',
        ];
    }
}
