@extends('layouts.general')

@section('title', '書籍リクエスト')

@section('content')
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-2 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-2">書籍リクエスト</h1>
            <p class="text-secondary mb-0">蔵書に追加してほしい本をリクエストできます。</p>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="status">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <p class="fw-semibold mb-1">入力内容を確認してください。</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-5">
        <div class="card-body p-4">
            <h2 class="h5 fw-bold mb-3">新しいリクエスト</h2>
            <form action="{{ route('book-requests.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label for="title" class="form-label fw-semibold">
                            書名 <span class="badge bg-danger ms-1">必須</span>
                        </label>
                        <input id="title" name="title" type="text" class="form-control"
                            value="{{ old('title') }}" maxlength="255" placeholder="書名を入力してください" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="author" class="form-label fw-semibold">著者</label>
                        <input id="author" name="author" type="text" class="form-control"
                            value="{{ old('author') }}" maxlength="255" placeholder="著者名を入力してください">
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="isbn" class="form-label fw-semibold">ISBN</label>
                        <input id="isbn" name="isbn" type="text" class="form-control"
                            value="{{ old('isbn') }}" maxlength="20" placeholder="ISBNを入力してください">
                    </div>
                    <div class="col-12">
                        <label for="reason" class="form-label fw-semibold">
                            リクエスト理由 <span class="badge bg-danger ms-1">必須</span>
                        </label>
                        <textarea id="reason" name="reason" class="form-control" rows="4"
                            maxlength="2000" required>{{ old('reason') }}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-primary">リクエストを送信</button>
                </div>
            </form>
        </div>
    </div>

    <section aria-labelledby="my-requests-title">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 id="my-requests-title" class="h4 fw-bold mb-0">リクエスト一覧</h2>
            <span class="text-secondary small">全{{ $bookRequests->total() }}件</span>
        </div>

        @forelse ($bookRequests as $bookRequest)
            <article class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-3">
                        <h3 class="h5 fw-bold mb-0">{{ $bookRequest->title }}</h3>
                        <span class="badge text-bg-secondary align-self-start">
                            {{ $statuses[$bookRequest->status] ?? $bookRequest->status }}
                        </span>
                    </div>
                    <dl class="row small mb-0">
                        <dt class="col-sm-3 text-secondary">著者</dt>
                        <dd class="col-sm-9">{{ $bookRequest->author ?: '未入力' }}</dd>
                        <dt class="col-sm-3 text-secondary">ISBN</dt>
                        <dd class="col-sm-9">{{ $bookRequest->isbn ?: '未入力' }}</dd>
                        @if ($bookRequest->user_id === Auth::id())
                            <dt class="col-sm-3 text-secondary">リクエスト理由</dt>
                            <dd class="col-sm-9">{{ $bookRequest->reason }}</dd>
                        @endif
                        @if ($bookRequest->user_id === Auth::id() && $bookRequest->admin_note)
                            <dt class="col-sm-3 text-secondary">管理者からのコメント</dt>
                            <dd class="col-sm-9 mb-0">{{ $bookRequest->admin_note }}</dd>
                        @endif
                    </dl>
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                        @if (Auth::user()->role === 'general')
                            <form
                                action="{{ route('book-requests.likes.toggle', $bookRequest) }}"
                                method="POST"
                                data-like-form
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="btn btn-sm {{ $bookRequest->liked_by_me_count > 0 ? 'btn-primary' : 'btn-outline-primary' }}"
                                    aria-pressed="{{ $bookRequest->liked_by_me_count > 0 ? 'true' : 'false' }}"
                                    aria-label="{{ $bookRequest->liked_by_me_count > 0 ? 'いいねを取り消す' : 'いいね' }}"
                                    title="{{ $bookRequest->liked_by_me_count > 0 ? 'いいねを取り消す' : 'いいね' }}"
                                    data-like-button
                                >
                                    <span class="book-request-like-icon" aria-hidden="true">👍</span>
                                    <span class="ms-1">いいね</span>
                                    <span class="book-request-like-count ms-1" data-like-count>{{ $bookRequest->likes_count }}人</span>
                                </button>
                                <span class="visually-hidden" data-like-status role="status" aria-live="polite"></span>
                            </form>
                        @else
                            <span class="text-primary small">いいね: {{ $bookRequest->likes_count }}人</span>
                        @endif
                        <p class="text-secondary small mb-0">
                            申請日: {{ $bookRequest->created_at->copy()->setTimezone('Asia/Tokyo')->format('Y年m月d日 H:i') }}
                        </p>
                    </div>
                </div>
            </article>
        @empty
            <div class="alert alert-light border text-secondary">
                まだリクエストはありません。
            </div>
        @endforelse

        {{ $bookRequests->links('pagination::bootstrap-5') }}
    </section>

    <script>
        document.querySelectorAll('[data-like-form]').forEach((form) => {
            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                const button = form.querySelector('[data-like-button]');
                const icon = form.querySelector('.book-request-like-icon');
                const count = form.querySelector('[data-like-count]');
                const status = form.querySelector('[data-like-status]');

                if (!button || !icon || !count || !status || button.disabled) {
                    return;
                }

                button.disabled = true;
                status.textContent = '';

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: new FormData(form),
                    });
                    const result = await response.json();

                    if (!response.ok || typeof result.liked !== 'boolean' || !Number.isInteger(result.likes_count)) {
                        throw new Error('The like request returned an invalid response.');
                    }

                    const label = result.liked ? 'いいねを取り消す' : 'いいね';
                    button.setAttribute('aria-pressed', String(result.liked));
                    button.setAttribute('aria-label', label);
                    button.title = label;
                    button.classList.toggle('btn-primary', result.liked);
                    button.classList.toggle('btn-outline-primary', !result.liked);
                    count.textContent = `${result.likes_count}人`;
                    icon.classList.remove('is-animating');
                    count.classList.remove('is-animating');
                    void icon.offsetWidth;
                    icon.classList.add('is-animating');
                    count.classList.add('is-animating');
                    status.textContent = result.liked ? 'いいねしました。' : 'いいねを取り消しました。';
                } catch (error) {
                    status.textContent = 'いいねを更新できませんでした。時間をおいてもう一度お試しください。';
                    console.error('Failed to update book request like.', error);
                } finally {
                    button.disabled = false;
                }
            });
        });
    </script>
@endsection
