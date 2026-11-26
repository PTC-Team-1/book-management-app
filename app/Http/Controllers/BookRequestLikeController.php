<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookRequestLikeController extends Controller
{
    public function toggle(Request $request, BookRequest $bookRequest): JsonResponse|RedirectResponse
    {
        abort_unless($request->user()->role === 'general', 403);

        $liked = DB::transaction(function () use ($request, $bookRequest): bool {
            $lockedBookRequest = BookRequest::query()
                ->whereKey($bookRequest->id)
                ->lockForUpdate()
                ->firstOrFail();

            $like = $lockedBookRequest->likes()
                ->where('user_id', $request->user()->id)
                ->first();

            if ($like) {
                $like->delete();

                return false;
            }

            $lockedBookRequest->likes()->create([
                'user_id' => $request->user()->id,
            ]);

            return true;
        });

        if ($request->expectsJson()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $bookRequest->likes()->count(),
            ]);
        }

        return redirect()->route('book-requests.index');
    }
}
