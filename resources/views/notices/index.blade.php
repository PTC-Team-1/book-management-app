<h1>お知らせ一覧</h1>

@foreach($notices as $notice)
    <div>
        <h3>
            <a href="/books/notices/{{ $notice->id }}">{{ $notice->title }}</a>
        </h3>
        <p>{{ $notice->created_at }}</p>
    </div>
@endforeach