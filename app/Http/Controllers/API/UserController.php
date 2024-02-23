<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        return response()->json(['user' => $user], 201);
    }

    public function show(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function update(StoreUserRequest $request, User $user)
    {
        $user->update($request->all());
        return response()->json(['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}