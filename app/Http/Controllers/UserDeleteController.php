<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;

class UserDeleteController extends Controller
{
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
}
