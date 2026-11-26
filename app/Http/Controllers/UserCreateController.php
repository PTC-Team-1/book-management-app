<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class UserCreateController extends Controller
{
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
}
