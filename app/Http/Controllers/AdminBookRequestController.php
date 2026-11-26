<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminBookRequestController extends Controller
{
    public function index(): View
    {
        return view('book-requests.admin.index', [
            'bookRequests' => BookRequest::query()
                ->with('user')
                ->withCount('likes')
                ->latest()
                ->paginate(20),
            'statuses' => BookRequest::STATUSES,
        ]);
    }

    public function update(Request $request, BookRequest $bookRequest): RedirectResponse
    {
        $validatedData = $request->validate([
            'status' => ['required', Rule::in(array_keys(BookRequest::STATUSES))],
            'admin_note' => ['nullable', 'string', 'max:2000'],
        ]);

        $bookRequest->status = $validatedData['status'];
        $bookRequest->admin_note = $validatedData['admin_note'] ?? null;
        $bookRequest->save();

        return redirect()
            ->route('book-requests.index')
            ->with('status', 'リクエストの対応状況を更新しました。');
    }
}
