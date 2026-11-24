<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserSearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('user-search');
        }

        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        $users = $query->get();

        $data = [
            'users' => $users
        ];

        return view('user-search', $data);
    }
}
