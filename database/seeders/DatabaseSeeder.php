<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $defaultServices = [
            'إصدار رخصة',
            'تجديد بطاقة',
            'تحديث البيانات',
        ];

        foreach ($defaultServices as $serviceName) {
            Service::query()->firstOrCreate([
                'name' => $serviceName,
            ], [
                'is_active' => true,
            ]);
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),

        ]);
    }
}
