<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateReq;
use App\Http\Requests\UserUpdateReq;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $perPage = request()->get('perPage', 30);
        return  app('res')->success(
            User::orderBy('id', 'DESC')->paginate($perPage),
            'Users fetched successfully.'
        );
    }

    public function show(User $user)
    {
        return app('res')->success($user, 'User fetched successfully.');
    }

    public function store(UserCreateReq $request)
    {
        $data = $request->validated();
        if ($user = User::create($data))
            return app('res')->success($user, 'User created successfully.');
        return app('res')->error('error while saving user');
    }

    public function update(UserUpdateReq $request, User $user)
    {

        $data = $request->validated();
        $user->name = $data['name'] ?? $user->name;
        $user->email = $data['email'] ?? $user->email;
        $user->tel = $data['tel'] ?? $user->tel;
        $user->role = $data['role'] ?? $user->role;
        // $data['password'] ??= null;
        // if ($data['password'])
        //     $user->password = bcrypt($data['password']);
        dd($user,$user->save());
        if ($user->save())
            return app('res')->success($user, 'User updated successfully.');
        return app('res')->error('error while updating user');
    }
}
