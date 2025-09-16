<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserCreateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('auth/register');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserCreateRequest $userCreateRequest): RedirectResponse
    {
        $user = User::create([
            'name' => $userCreateRequest->name,
            'email' => $userCreateRequest->email,
            'password' => Hash::make($userCreateRequest->password),
        ]);

        $user->userRole()->create(['role' => 'admin']);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
