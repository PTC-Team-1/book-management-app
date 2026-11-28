<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <label for="batch-isbn" class="form-label fw-semibold">ISBNバーコード</label>
        <div class="input-group">
            <input
                type="text"
                class="form-control"
                id="batch-isbn"
                placeholder="バーコードリーダーで読み取ってください"
                autocomplete="off"
            >
            <button type="button" class="btn btn-primary" id="add-isbn">
                ISBNを追加
            </button>
        </div>
        <div class="form-text">
            リーダーが読み取り後にEnterを送る設定なら自動で追加されます。
            Enterを送らない場合は「ISBNを追加」を押してください。
            ISBNを追加した後も次の読み取りを続けられます。
        </div>
        <div id="scan-status" class="small mt-2" role="status" aria-live="polite"></div>
    </div>
</div>

<template id="book-category-options">
    {{-- 2026年11月27日追記: 一括登録でも各書籍のカテゴリを個別に選択できるようにする。 --}}
    <option value="">カテゴリを選択してください</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</template>

<form
    action="{{ route('admin.books.batch-store') }}"
    method="POST"
    id="batch-form"
    data-lookup-url="{{ route('admin.books.isbn-lookup') }}"
    data-restored-books="{{ json_encode(old('books', [])) }}"
>
    @csrf
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h2 class="h5 fw-bold mb-0">登録前の確認</h2>
            <span class="text-secondary small" id="queue-count">0 / 10冊</span>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0 book-batch-table">
                <thead class="table-light">
                    <tr>
                        <th scope="col">ISBN</th>
                        <th scope="col">書名</th>
                        <th scope="col">著者</th>
                        <th scope="col">出版社</th>
                        <th scope="col">出版日</th>
                        <th scope="col">カテゴリ</th>
                        <th scope="col">詳細</th>
                        <th scope="col">状態</th>
                        <th scope="col">操作</th>
                    </tr>
                </thead>
                <tbody id="book-queue">
                    <tr id="empty-queue">
                        <td colspan="9" class="text-center text-secondary p-4">
                            ISBNを読み取ると、ここに書籍が追加されます。
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-body d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" id="save-batch" disabled>
                確認した書籍を一括登録
            </button>
        </div>
    </div>
</form>

<script>
    const isbnInput = document.getElementById('batch-isbn');
    const addButton = document.getElementById('add-isbn');
    const queueBody = document.getElementById('book-queue');
    const queueCount = document.getElementById('queue-count');
    const saveButton = document.getElementById('save-batch');
    const scanStatus = document.getElementById('scan-status');
    const batchForm = document.getElementById('batch-form');
    const categoryOptions = document.getElementById('book-category-options');
    const lookupUrl = batchForm.dataset.lookupUrl;
    const restoredBooks = JSON.parse(batchForm.dataset.restoredBooks || '[]');
    const queue = Array.isArray(restoredBooks)
        ? restoredBooks.map((book) => ({
            isbn: String(book.isbn || ''),
            title: String(book.title || ''),
            author: String(book.author || ''),
            publisher: String(book.publisher || ''),
            published_date: String(book.published_date || ''),
            category_id: String(book.category_id || ''),
            description: String(book.description || ''),
            cover_image: String(book.cover_image ?? book.cover_image_url ?? ''),
            status: 'ready',
            error: '',
        }))
        : [];
    let processingLookups = false;

    const setScanStatus = (message, isError = false) => {
        scanStatus.textContent = message;
        scanStatus.className = isError
            ? 'small mt-2 text-danger'
            : 'small mt-2 text-secondary';
    };

    const addField = (cell, book, index, field, label, type = 'text', multiline = false) => {
        const input = document.createElement(multiline ? 'textarea' : 'input');
        input.className = 'form-control form-control-sm';
        input.name = `books[${index}][${field}]`;
        input.setAttribute('aria-label', `${index + 1}冊目 ${label}`);
        input.value = book[field] || '';

        if (multiline) {
            input.rows = 2;
        } else {
            input.type = type;
        }

        if (field === 'title' || field === 'isbn') {
            input.required = true;
        }
        input.disabled = queue.some((item) => item.status === 'pending' || item.status === 'loading');

        input.addEventListener('input', () => {
            book[field] = input.value;
        });

        cell.appendChild(input);
    };

    const updateControls = () => {
        queueCount.textContent = `${queue.length} / 10冊`;
        isbnInput.disabled = queue.length >= 10;
        addButton.disabled = queue.length >= 10;
        saveButton.disabled = queue.length === 0
            || queue.some((book) => book.status === 'pending' || book.status === 'loading');
    };

    const addCategoryField = (cell, book, index) => {
        const select = document.createElement('select');
        select.className = 'form-select form-select-sm';
        select.name = `books[${index}][category_id]`;
        select.setAttribute('aria-label', `${index + 1}冊目 カテゴリ`);
        select.appendChild(categoryOptions.content.cloneNode(true));
        select.value = book.category_id || '';
        select.disabled = queue.some((item) => item.status === 'pending' || item.status === 'loading');
        select.addEventListener('change', () => {
            book.category_id = select.value;
        });
        cell.appendChild(select);
    };

    const renderQueue = () => {
        queueBody.replaceChildren();

        if (queue.length === 0) {
            const row = document.createElement('tr');
            const cell = document.createElement('td');
            cell.colSpan = 9;
            cell.className = 'text-center text-secondary p-4';
            cell.textContent = 'ISBNを読み取ると、ここに書籍が追加されます。';
            row.appendChild(cell);
            queueBody.appendChild(row);
            updateControls();

            return;
        }

        queue.forEach((book, index) => {
            const row = document.createElement('tr');

            ['isbn', 'title', 'author', 'publisher', 'published_date'].forEach((field) => {
                const cell = document.createElement('td');
                addField(
                    cell,
                    book,
                    index,
                    field,
                    { isbn: 'ISBN', title: '書名', author: '著者', publisher: '出版社', published_date: '出版日' }[field],
                    field === 'published_date' ? 'date' : 'text'
                );
                row.appendChild(cell);
            });

            const categoryCell = document.createElement('td');
            addCategoryField(categoryCell, book, index);
            row.appendChild(categoryCell);

            const detailsCell = document.createElement('td');
            const details = document.createElement('details');
            const summary = document.createElement('summary');
            summary.textContent = '編集';
            details.appendChild(summary);
            addField(details, book, index, 'description', '説明文', 'text', true);
            addField(details, book, index, 'cover_image', '画像URL', 'url');
            detailsCell.appendChild(details);
            row.appendChild(detailsCell);

            const statusCell = document.createElement('td');
            statusCell.className = book.status === 'failed' ? 'text-danger small' : 'small';
            if (book.status === 'failed' && book.error) {
                statusCell.title = book.error;
            }
            statusCell.textContent = book.status === 'ready'
                ? '取得済み'
                : book.status === 'loading'
                    ? '検索中'
                    : book.status === 'failed'
                        ? '自動取得に失敗'
                        : '検索待ち';
            row.appendChild(statusCell);

            const actionCell = document.createElement('td');
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-sm btn-outline-danger';
            removeButton.textContent = '削除';
            removeButton.setAttribute('aria-label', `${index + 1}冊目を一覧から削除`);
            removeButton.addEventListener('click', () => {
                queue.splice(index, 1);
                renderQueue();
                isbnInput.focus();
            });
            actionCell.appendChild(removeButton);
            row.appendChild(actionCell);

            queueBody.appendChild(row);
        });

        updateControls();
    };

    const processPendingLookups = async () => {
        if (processingLookups) {
            return;
        }

        processingLookups = true;

        try {
            let book;
            while ((book = queue.find((item) => item.status === 'pending'))) {
                book.status = 'loading';
                renderQueue();

                try {
                    const response = await fetch(
                        `${lookupUrl}?isbn=${encodeURIComponent(book.isbn)}`,
                        { headers: { Accept: 'application/json' } }
                    );
                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.message || '書籍情報を取得できませんでした。');
                    }

                    Object.assign(book, result, { status: 'ready', error: '' });
                } catch (error) {
                    book.status = 'failed';
                    book.error = error instanceof Error
                        ? error.message
                        : '書籍情報を取得できませんでした。';
                }

                renderQueue();
            }
        } finally {
            processingLookups = false;
            updateControls();
            isbnInput.focus();
        }
    };

    const addScannedIsbn = () => {
        const isbn = isbnInput.value.replace(/[\s-]+/g, '').trim().toUpperCase();

        if (!isbn) {
            setScanStatus('先にISBNを読み取ってください。', true);
            isbnInput.focus();

            return;
        }

        if (!/^(?:\d{13}|\d{9}[\dX])$/.test(isbn)) {
            setScanStatus('ISBNを正しく読み取れませんでした。再度スキャンしてください。', true);
            isbnInput.focus();
            isbnInput.select();

            return;
        }

        if (queue.some((book) => book.isbn === isbn)) {
            setScanStatus('このISBNはすでに一覧にあります。', true);
            isbnInput.value = '';
            isbnInput.focus();

            return;
        }

        if (queue.length >= 10) {
            setScanStatus('一度に登録できるのは10冊までです。', true);

            return;
        }

        queue.push({
            isbn,
            title: '',
            author: '',
            publisher: '',
            published_date: '',
            category_id: '',
            description: '',
            cover_image: '',
            status: 'pending',
            error: '',
        });

        isbnInput.value = '';
        setScanStatus('ISBNを追加しました。続けてスキャンできます。');
        renderQueue();
        isbnInput.focus();
        processPendingLookups();
    };

    isbnInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            addScannedIsbn();
        }
    });

    addButton.addEventListener('click', addScannedIsbn);

    renderQueue();
    if (queue.some((book) => book.status === 'pending')) {
        processPendingLookups();
    } else if (document.getElementById('batch-mode-tab').classList.contains('active')) {
        isbnInput.focus();
    }

    document.getElementById('batch-mode-tab').addEventListener('shown.bs.tab', () => {
        isbnInput.focus();
    });
</script>