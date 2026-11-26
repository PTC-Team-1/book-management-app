<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $data = [
            'users' => $users
        ];

        return view('users.index', $data);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed'],
            'role' => ['required', 'in:general,admin'],
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->password = $validatedData['password'];
        $user->role = $validatedData['role'];

        $user->save();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_CREATED,
            ActivityLog::SUBJECT_USER,
            $user->id,
        );

        $data = [
            'user' => $validatedData,
        ];

        return view('users.store', $data);
    }

    public function edit(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('users.edit');
        }

        $userId = $request->input('id');
        $userData = User::find($userId);
        $data = [
            'user' => $userData
        ];
        return view('users.edit', $data);
    }

    public function update(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'role' => ['required', 'in:general,admin'],
        ]);

        $user = User::find($validatedData['id']);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->role = $validatedData['role'];

        $user->save();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_UPDATED,
            ActivityLog::SUBJECT_USER,
            $user->id,
        );

        $data = [
            'user' => $validatedData,
        ];

        return view('users.update', $data);
    }

    public function erase(Request $request)
    {

        if ($request->isMethod('get')) {
            return view('users.erase');
        }

        $userId = $request->input('id');
        $userData = User::find($userId);
        $data = [
            'user' => $userData
        ];
        return view('users.erase', $data);
    }

    public function delete(Request $request, ActivityLogger $activityLogger)
    {
        $validatedData = $request->validate([
            'id' => 'required | exists:users,id',
        ]);

        $user = User::find($validatedData['id']);
        $user->delete();

        $activityLogger->record(
            $request->user(),
            ActivityLog::ACTION_DELETED,
            ActivityLog::SUBJECT_USER,
            $user->id,
        );

        $data = [
            'user' => $user
        ];

        return view('users.delete', $data);
    }

    public function search(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('users.search');
        }

        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $users = $query->get();

        $data = [
            'users' => $users
        ];

        return view('users.search', $data);
    }
}
