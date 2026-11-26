<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

// 2026年11月26日追記: お知らせの管理操作と社員向け詳細表示を担当。
class AnnouncementController extends Controller
{
    public function index(): View
    {
        return view('announcements.index', [
            'announcements' => Announcement::query()
                ->latest()
                ->paginate(20),
        ]);
    }

    // 2026年11月25日変更: 一般ページからお知らせ本文を読める詳細画面を追加。
    public function show(Announcement $announcement): View
    {
        return view('announcements.show', [
            'announcement' => $announcement,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        Announcement::create($validatedData);

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'お知らせを公開しました。');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('status', 'お知らせを削除しました。');
    }
}
