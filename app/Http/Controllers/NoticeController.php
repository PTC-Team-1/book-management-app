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

        return redirect('/books/notices');
    }

    public function show($id)
    {
        $notice = Notice::find($id);

        return view('notices.show', [
            'notice' => $notice
        ]);
    }

    public function edit($id)
    {
        $notice = Notice::find($id);
        return view('notices.edit', [
            'notice' => $notice
        ]);
    }

    public function update(Request $req, $id)
    {
        $notice = Notice::find($id);

        $notice->title = $req->title;
        $notice->body = $req->body;

        $notice->save();

        return redirect('/books/notices');
    }

    public function erase($id)
    {
        $notice = Notice::find($id);

        $notice->delete();

        return redirect('/books/notices');
    }
}
