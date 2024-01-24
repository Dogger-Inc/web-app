<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function show()
    {
        return inertia('Dashboard/Profile');
    }

    function editProfile() {
        $user = auth()->user();

        $data = request()->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns,spoof', 'max:255', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
        ]);

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Profile updated !',
        ]);
    }

    function resetPassword()
    {
        $user = auth()->user();

        $data = request()->validate([
            'old_password' => ['required', 'string', function($attribute, $value, $fail) use ($user) {
                if(!Hash::check($value, $user->password)) {
                    $fail('Current password is incorrect');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()],
        ]);

        $user->password = $data['password'];
        $user->save();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'Password updated !',
        ]);
    }
}