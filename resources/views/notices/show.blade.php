<h1>お知らせ詳細</h1>

<h2>{{ $notice->title }}</h2>
<p>{{ $notice->created_at }}</p>
<p>{{ $notice->body }}</p>

<a href="/books/notices">一覧に戻る</a>

@if (Auth::user()->role === 'admin')
    <a href="{{ route('admin.notices.edit', ['notice' => $notice->id]) }}">編集</a>

    <form action="{{ route('admin.notices.delete', ['notice' => $notice->id]) }}" method="POST">
        @csrf
        <button type="submit">削除</button>
    </form>
@endif