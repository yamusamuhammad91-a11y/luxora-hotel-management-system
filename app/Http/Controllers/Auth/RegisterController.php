<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Display the guest registration page.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Create a new guest account.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
            'terms' => ['accepted'],
        ], [
            'email.unique' => 'An account already exists with this email address. Please sign in instead.',
            'password.confirmed' => 'The password confirmation does not match.',
            'terms.accepted' => 'You must accept the terms to create an account.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
        ]);

        // The database default should assign the guest role.
        // Set it explicitly without accepting a role from the request.
        $user->role = 'guest';
        $user->save();

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('guest.dashboard')
            ->with('success', 'Welcome to Luxora. Your guest account has been created.');
    }
}
