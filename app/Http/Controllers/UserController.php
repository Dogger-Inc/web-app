<?php

namespace App\Http\Controllers;

use App\Mail\NewUserEmail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function list() {
        //$currentUser = auth()->user();
        // $users = $currentUser->company->users()->paginate(10);

        // return Inertia::render("Dashboard/Users", [
        //     'users' => $users,
        // ]);
    }

    public function create() {
        $user = auth()->user();

        $data = request()->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required','email:rfc,dns,spoof','max:255', Rule::unique('users')],
            'password' => ['required', 'string', 'min:8', 'max255'],
        ]);

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        //à voir pour réimplémenter
        //Mail::to($user["email"])->send(new NewUserEmail($user, $password));

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'User created !',
        ]);
    }

    public function delete(User $user) {
        $user->delete();

        return redirect()->back()->with('toast', [
            'type' => 'success',
            'message' => 'User deleted !',
        ]);
    }
}