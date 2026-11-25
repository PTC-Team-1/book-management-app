<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        return view('notices.index', [
            'notices' => $notices
        ]);
    }

    public function show(Notice $notice)
    {
        $notice = Notice::where('user_id', Auth::id())->findOrFail($notice->id);
        if ($notice->user_id === Auth::id() && is_null($notice->read_at)) {
            $notice->read_at = now();
            $notice->save();
        }
        return view('notices.show', [
            'notice' => $notice
        ]);
    }

    public function edit(Notice $notice)
    {
        return view('notices.edit', [
            'notice' => $notice
        ]);
    }

    public function update(Request $req, Notice $notice)
    {
        $notice->title = $req->title;
        $notice->body = $req->body;

        $notice->save();

        return redirect(route('notices.index'));
    }

    public function erase(Notice $notice)
    {
        $notice->delete();

        return redirect(route('notices.index'));
    }
}
