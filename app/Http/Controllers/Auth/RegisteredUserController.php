<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegisteredUserController extends Controller
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
}
