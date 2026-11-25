<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::all();
        return view('notices.index', [
            'notices' => $notices
        ]);
    }

    public function create()
    {
        return view('notices.create');
    }

    public function store(Request $req)
    {
        $notice = new Notice();

        $notice->title = $req->title;
        $notice->body = $req->body;

        $notice->save();

        return redirect(route('notices.index'));
    }

    public function show(Notice $notice)
    {
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
