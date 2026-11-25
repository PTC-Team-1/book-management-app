<h1>お知らせ登録</h1>

<form action="{{ route('admin.notices.store') }}" method="POST">
    @csrf

    <div>
        <label>タイトル</label>
        <input type="text" name="title">
    </div>

    <div>
        <label>本文</label>
        <textarea type="text" name="body"></textarea>
    </div>

    <button type="submit">登録</button>
</form>