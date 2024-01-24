<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function show()
    {
        return inertia('Dashboard/Profile');
    }

    function editProfile() {
        $data = request()->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        $user = auth()->user();
        $user->firstname = $data['firstname'];
        $user->lastname = $data['lastname'];
        $user->email = $data['email'];
        $user->save();

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