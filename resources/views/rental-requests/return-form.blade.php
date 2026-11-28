@extends('layouts.admin')

@section('title', '書籍返却')

@section('content')

    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍返却</h1>
        <p class="text-secondary mb-0">
            ISBNの連続読み取りで返却対象を確認できます。
        </p>
    </div>

    <div class="tab-content">
        <div
            class="tab-pane fade show active"
            id="return-batch-pane"
            role="tabpanel"
            aria-labelledby="return-batch-tab"
        >
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <label for="return-batch-isbn" class="form-label fw-semibold">ISBNバーコード</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="return-batch-isbn"
                            placeholder="バーコードリーダーで読み取ってください"
                            autocomplete="off"
                        >
                        <button type="button" class="btn btn-primary" id="add-return-isbn">
                            ISBNを追加
                        </button>
                    </div>
                    <div class="form-text">
                        リーダーが読み取り後にEnterを送る設定なら自動で追加されます。
                        Enterを送らない場合は「ISBNを追加」を押してください。
                        ISBNを追加した後も次の読み取りを続けられます。
                    </div>
                    <div id="return-scan-status" class="small mt-2" role="status" aria-live="polite"></div>
                </div>
            </div>

            <form
                action="{{ route('admin.books.rentals.return.batch-store') }}"
                method="POST"
                id="return-batch-form"
                data-lookup-url="{{ route('admin.books.isbn-lookup') }}"
                data-restored-books="{{ json_encode(old('isbns', [])) }}"
            >
                @csrf
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h2 class="h5 fw-bold mb-0">返却対象の確認</h2>
                        <span class="text-secondary small" id="return-queue-count">0 / 10冊</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ISBN</th>
                                    <th scope="col">書名</th>
                                    <th scope="col">状態</th>
                                    <th scope="col">操作</th>
                                </tr>
                            </thead>
                            <tbody id="return-book-queue">
                                <tr>
                                    <td colspan="4" class="text-center text-secondary p-4">
                                        ISBNを読み取ると、ここに返却対象が追加されます。
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" id="save-return-batch" disabled>
                            確認した書籍を一括返却
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        (() => {
            const maxBooks = 10;
            const isbnInput = document.getElementById('return-batch-isbn');
            const addButton = document.getElementById('add-return-isbn');
            const queueBody = document.getElementById('return-book-queue');
            const queueCount = document.getElementById('return-queue-count');
            const saveButton = document.getElementById('save-return-batch');
            const scanStatus = document.getElementById('return-scan-status');
            const batchForm = document.getElementById('return-batch-form');
            const batchTab = document.getElementById('return-batch-tab');
            const lookupUrl = batchForm.dataset.lookupUrl;
            const restoredIsbns = JSON.parse(batchForm.dataset.restoredBooks || '[]');

            const queue = Array.isArray(restoredIsbns)
                ? restoredIsbns.map((isbn) => ({
                    isbn: String(isbn || ''),
                    title: '',
                    status: 'pending',
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

            const isBusy = () => queue.some((item) => item.status === 'pending' || item.status === 'loading');

            const hasInvalidOrUnverified = () => queue.some((item) => item.status !== 'ready');

            const updateControls = () => {
                queueCount.textContent = `${queue.length} / ${maxBooks}冊`;
                isbnInput.disabled = queue.length >= maxBooks;
                addButton.disabled = queue.length >= maxBooks;
                saveButton.disabled = queue.length === 0 || isBusy() || hasInvalidOrUnverified();
            };

            const renderQueue = () => {
                queueBody.replaceChildren();

                if (queue.length === 0) {
                    const row = document.createElement('tr');
                    const cell = document.createElement('td');
                    cell.colSpan = 4;
                    cell.className = 'text-center text-secondary p-4';
                    cell.textContent = 'ISBNを読み取ると、ここに返却対象が追加されます。';
                    row.appendChild(cell);
                    queueBody.appendChild(row);
                    updateControls();

                    return;
                }

                queue.forEach((item, index) => {
                    const row = document.createElement('tr');

                    // 送信用のISBN値と表示用テキスト
                    const isbnCell = document.createElement('td');
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `isbns[${index}]`;
                    hiddenInput.value = item.isbn;
                    isbnCell.appendChild(hiddenInput);
                    isbnCell.appendChild(document.createTextNode(item.isbn));
                    row.appendChild(isbnCell);

                    // 書名（確認取得後に表示）
                    const titleCell = document.createElement('td');
                    titleCell.textContent = item.title || '—';
                    row.appendChild(titleCell);

                    // 確認状況
                    const statusCell = document.createElement('td');
                    statusCell.className = item.status === 'failed' ? 'text-danger small' : 'small';
                    if (item.status === 'failed' && item.error) {
                        statusCell.title = item.error;
                    }
                    statusCell.textContent = item.status === 'ready'
                        ? '返却可能（貸出中）'
                        : item.status === 'loading'
                            ? '確認中'
                            : item.status === 'failed'
                                ? (item.error || '返却対象外')
                                : '確認待ち';
                    row.appendChild(statusCell);

                    // 操作
                    const actionCell = document.createElement('td');
                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'btn btn-sm btn-outline-danger';
                    removeButton.textContent = '削除';
                    removeButton.disabled = isBusy();
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
                if (processingLookups || !lookupUrl) {
                    return;
                }

                processingLookups = true;

                try {
                    let target;
                    while ((target = queue.find((item) => item.status === 'pending'))) {
                        target.status = 'loading';
                        renderQueue();

                        try {
                            const response = await fetch(
                                `${lookupUrl}?isbn=${encodeURIComponent(target.isbn)}`,
                                { headers: { Accept: 'application/json' } }
                            );
                            const result = await response.json();

                            if (!response.ok) {
                                throw new Error(result.message || '貸出中の書籍を確認できませんでした。');
                            }

                            target.title = String(result.title || '');
                            target.status = 'ready';
                            target.error = '';
                        } catch (error) {
                            target.status = 'failed';
                            target.error = error instanceof Error
                                ? error.message
                                : '貸出中の書籍を確認できませんでした。';
                        }

                        renderQueue();
                    }
                } finally {
                    processingLookups = false;
                    updateControls();
                    if (batchTab.classList.contains('active')) {
                        isbnInput.focus();
                    }
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

                if (queue.some((item) => item.isbn === isbn)) {
                    setScanStatus('このISBNはすでに一覧にあります。', true);
                    isbnInput.value = '';
                    isbnInput.focus();

                    return;
                }

                if (queue.length >= maxBooks) {
                    setScanStatus(`一度に返却できるのは${maxBooks}冊までです。`, true);

                    return;
                }

                queue.push({
                    isbn,
                    title: '',
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

            batchTab.addEventListener('shown.bs.tab', () => {
                isbnInput.focus();
            });

            renderQueue();
            if (queue.some((item) => item.status === 'pending')) {
                processPendingLookups();
            } else if (batchTab.classList.contains('active')) {
                isbnInput.focus();
            }
        })();
    </script>

@endsection