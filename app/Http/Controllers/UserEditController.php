<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserEditController extends Controller
{
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
}
