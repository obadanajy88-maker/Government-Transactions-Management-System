<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'transaction_code' => 'TR-'.strtoupper(uniqid()),
            'user_id' => User::factory(),
            'service_id' => Service::factory(),
            'status' => 'pending',
            'current_handler_id' => null,
            'notes' => fake()->sentence(),
        ];
    }
}
