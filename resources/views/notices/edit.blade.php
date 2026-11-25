<h1>お知らせ編集</h1>

<form action="{{ route('admin.notices.update', ['notice' => $notice->id]) }}" method="POST">
    @csrf
    <div>
        <label>タイトル</label>
        <input type="text" name="title" value="{{ $notice->title }}">
    </div>

    <div>
        <label>本文</label>
        <textarea name="body">{{ $notice->body }}</textarea>
    </div>

    <button type="submit">更新</button>
</form>