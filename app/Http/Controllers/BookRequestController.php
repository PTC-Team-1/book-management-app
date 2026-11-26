<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    public function index(Request $request): View
    {
        return view('book-requests.index', [
            'bookRequests' => BookRequest::query()
                ->withCount('likes')
                ->withCount([
                    'likes as liked_by_me_count' => fn (Builder $query) => $query
                        ->where('user_id', $request->user()->id),
                ])
                ->latest()
                ->paginate(10),
            'statuses' => BookRequest::STATUSES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:20'],
            'reason' => ['required', 'string', 'max:2000'],
        ]);

        $request->user()->bookRequests()->create($validatedData);

        return redirect()
            ->route('book-requests.index')
            ->with('status', '書籍リクエストを送信しました。');
    }
}
