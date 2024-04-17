<?php

namespace App\Http\Controllers;

use App\Models\User;

class UsersController extends Controller
{
    public function search(): \Illuminate\Http\JsonResponse
    {
        $data = request()->validate([
            'property' => ['required', 'string'],
            'search' => ['string'],
        ]);

        $users = User::where($data['property'], 'LIKE', "%". $data['search'] ."%")->get();

        return response()->json($users);
    }
}
