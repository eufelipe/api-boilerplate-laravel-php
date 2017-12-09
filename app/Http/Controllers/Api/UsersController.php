<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\UsersRequest as Request;

class UsersController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->get('password'));
        return User::create($data);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->get('password'));
        $user->update($data);
        return $user;
    }

    public function show(User $user)
    {
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $user;
    }
}
