<?php

use App\Models\Attachment;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('registers a citizen and stores the required profile fields', function () {
    $response = $this->post('/register', [
        'full_name' => 'Obada Ahmed',
        'email' => 'citizen@example.com',
        'national_id' => '12345678901234',
        'phone_number' => '0501234567',
        'role' => 'citizen',
        'password' => 'Secret123!',
        'password_confirmation' => 'Secret123!',
    ]);

    $response->assertRedirect('/citizen/transactions/create');

    $this->assertDatabaseHas('users', [
        'email' => 'citizen@example.com',
        'full_name' => 'Obada Ahmed',
        'national_id' => '12345678901234',
        'phone_number' => '0501234567',
        'role' => 'citizen',
    ]);
});

it('allows a citizen to submit a transaction with an attachment', function () {
    Storage::fake('public');

    $citizen = User::factory()->create([
        'role' => 'citizen',
    ]);

    $service = Service::factory()->create([
        'name' => 'إصدار رخصة',
        'is_active' => true,
    ]);

    $response = $this->actingAs($citizen)
        ->post('/citizen/transactions', [
            'service_id' => $service->id,
            'notes' => 'طلب جديد',
            'attachments' => [
                UploadedFile::fake()->create('identity.pdf', 100, 'application/pdf'),
            ],
        ]);

    $response->assertSessionHas('success');
    $response->assertRedirect();

    $transaction = Transaction::query()->where('user_id', $citizen->id)->firstOrFail();
    expect($transaction->status)->toBe('pending');
    expect($transaction->transaction_code)->not->toBeEmpty();
    expect($transaction->attachments)->toHaveCount(1);
    expect(Attachment::query()->where('transaction_id', $transaction->id)->exists())->toBeTrue();
});

it('routes each role to its own dashboard experience', function () {
    $citizen = User::factory()->create([
        'role' => 'citizen',
    ]);

    $employee = User::factory()->create([
        'role' => 'employee',
    ]);

    $manager = User::factory()->create([
        'role' => 'manager',
    ]);

    $this->actingAs($citizen)
        ->get('/dashboard')
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('dashboard'));

    $this->actingAs($employee)
        ->get('/dashboard')
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('dashboard'));

    $this->actingAs($manager)
        ->get('/dashboard')
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('dashboard'));
});

it('redirects employees and managers to the processing queue after login', function () {
    $employee = User::factory()->create([
        'role' => 'employee',
    ]);

    $manager = User::factory()->create([
        'role' => 'manager',
    ]);

    $this->post('/login', [
        'email' => $employee->email,
        'password' => 'password',
    ])->assertRedirect(route('employee.transactions.index', absolute: false));

    auth()->logout();

    $this->post('/login', [
        'email' => $manager->email,
        'password' => 'password',
    ])->assertRedirect(route('employee.transactions.index', absolute: false));
});

it('seeds a default set of active services for the transaction form', function () {
    $this->seed(DatabaseSeeder::class);

    expect(Service::query()->where('is_active', true)->count())->toBeGreaterThan(0);
});

it('shows a structured follow-up section for employee transaction processing', function () {
    $employee = User::factory()->create([
        'role' => 'employee',
    ]);

    $citizen = User::factory()->create([
        'role' => 'citizen',
    ]);

    $service = Service::factory()->create([
        'name' => 'تجديد بطاقة',
        'is_active' => true,
    ]);

    Transaction::factory()->create([
        'user_id' => $citizen->id,
        'service_id' => $service->id,
        'status' => 'pending',
        'current_handler_id' => null,
    ]);

    $this->actingAs($employee)
        ->get(route('employee.transactions.index', absolute: false))
        ->assertOk()
        ->assertSee('متابعة المعاملة')
        ->assertSee('استلام')
        ->assertSee('رفض')
        ->assertSee('تحويل');
});

it('allows an employee to claim and complete an assigned transaction', function () {
    $employee = User::factory()->create([
        'role' => 'employee',
    ]);

    $citizen = User::factory()->create([
        'role' => 'citizen',
    ]);

    $service = Service::factory()->create([
        'name' => 'تجديد بطاقة',
        'is_active' => true,
    ]);

    $transaction = Transaction::factory()->create([
        'user_id' => $citizen->id,
        'service_id' => $service->id,
        'status' => 'pending',
        'current_handler_id' => null,
    ]);

    $this->actingAs($employee)
        ->post(route('employee.transactions.process', $transaction), [
            'action' => 'claim',
        ])
        ->assertRedirect();

    $transaction->refresh();
    expect($transaction->current_handler_id)->toBe($employee->id)
        ->and($transaction->status)->toBe('in_progress');

    $this->actingAs($employee)
        ->post(route('employee.transactions.process', $transaction), [
            'action' => 'complete',
        ])
        ->assertRedirect();

    $transaction->refresh();
    expect($transaction->status)->toBe('completed');
});
