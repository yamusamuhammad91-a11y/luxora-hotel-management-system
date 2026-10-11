<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class GuestProfileController extends Controller
{
    /**
     * Display the signed-in guest's profile.
     */
    public function edit(Request $request)
    {
        return view('guest.profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the signed-in guest's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'current_password' => [
                'nullable',
                'required_with:password',
                'string',
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->symbols(),
            ],
        ], [
            'email.unique' => 'This email address is already registered.',
            'current_password.required_with' =>
                'Enter your current password before choosing a new one.',
            'password.confirmed' =>
                'Your new password confirmation does not match.',
        ]);

        if (! empty($validated['password'])) {
            if (
                empty($validated['current_password']) ||
                ! Hash::check($validated['current_password'], $user->password)
            ) {
                return back()
                    ->withErrors([
                        'current_password' =>
                            'Your current password is incorrect.',
                    ])
                    ->withInput($request->except([
                        'current_password',
                        'password',
                        'password_confirmation',
                    ]));
            }
        }

        $oldEmail = strtolower($user->email);
        $newEmail = strtolower($validated['email']);
        $newName = $validated['name'];

        DB::transaction(function () use (
            $user,
            $validated,
            $oldEmail,
            $newEmail,
            $newName
        ) {
            $user->name = $newName;
            $user->email = $newEmail;

            if (! empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            // Keep existing reservations associated with this account.
            DB::table('bookings')
                ->whereRaw('LOWER(guest_email) = ?', [$oldEmail])
                ->update([
                    'guest_email' => $newEmail,
                    'guest_name' => $newName,
                    'updated_at' => now(),
                ]);
        });

        return redirect()
            ->route('guest.profile.edit')
            ->with('success', 'Your profile has been updated successfully.');
    }
}
