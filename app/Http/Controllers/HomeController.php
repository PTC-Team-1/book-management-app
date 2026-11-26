<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Book;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function  index()
    {
        $books = Book::all();

        $hasUnreadNotices = Notice::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->exists();

        $bookNews = Book::query()
            ->latest()
            ->take(3)
            ->get()
            ->map(static fn(Book $book): array => [
                'type' => 'book',
                'id' => $book->id,
                'title' => $book->title,
                'created_at' => $book->created_at,
            ]);
        $announcementNews = Announcement::query()
            ->latest()
            ->take(3)
            ->get(['id', 'title', 'created_at'])
            ->map(static fn(Announcement $announcement): array => [
                'type' => 'announcement',
                'id' => $announcement->id,
                'title' => $announcement->title,
                'created_at' => $announcement->created_at,
            ]);

        $data = [
            'books' => $books,
            'hasUnreadNotices' => $hasUnreadNotices,
            'news' => $bookNews
                ->concat($announcementNews)
                ->sortByDesc('created_at')
                ->take(3)
                ->values(),
        ];
        return view('index', $data);
    }
}
