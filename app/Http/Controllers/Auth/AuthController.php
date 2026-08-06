<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'full_name' => $request->string('full_name')->trim(),
                'email' => $request->string('email')->trim(),
                'national_id' => $request->string('national_id')->trim(),
                'phone_number' => $request->string('phone_number')->trim(),
                'role' => $request->string('role')->value(),
                'password' => $request->password,
            ]);

            event(new Registered($user));

            return $user;
        });

        Auth::login($user);

        return redirect()->route($user->role === 'citizen' ? 'citizen.transactions.create' : 'employee.transactions.index');
    }

    public function loginForm(Request $request): View
    {
        return view('auth.login', [
            'status' => $request->session()->get('status'),
        ]);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended($this->redirectForRole(Auth::user()));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectForRole(?User $user): string
    {
        return match ($user?->role) {
            'citizen' => route('citizen.transactions.create', absolute: false),
            'employee', 'manager' => route('employee.transactions.index', absolute: false),
            default => route('dashboard', absolute: false),
        };
    }
}
