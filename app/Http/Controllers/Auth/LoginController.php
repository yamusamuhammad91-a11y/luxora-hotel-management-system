<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Authenticate an administrator or guest.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'The email address or password is incorrect.',
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();

        // Administrators go to the administration dashboard.
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        // Existing guest accounts go to the guest portal.
        if ($user->role === 'guest') {
            return redirect()->route('guest.dashboard');
        }

        // Prevent accounts with unexpected roles from remaining signed in.
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        throw ValidationException::withMessages([
            'email' => 'This account does not have permission to access the portal.',
        ]);
    }

    /**
     * Sign out the current user.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been signed out successfully.');
    }
}
