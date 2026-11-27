@extends('layouts.admin')

@section('title', '書籍返却')

@section('content')

    {{-- 2026年11月27日追記: 書籍登録のISBN連続操作に画面を揃えつつ、返却処理は未接続のまま分離する。 --}}
    <div class="mb-4">
        <h1 class="fw-bold mb-2">書籍返却</h1>
        <p class="text-secondary mb-0">
            1冊ずつの返却、またはISBNの連続読み取りで返却対象を確認できます。
        </p>
    </div>

    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="return-batch-tab"
                data-bs-toggle="tab"
                data-bs-target="#return-batch-pane"
                type="button"
                role="tab"
                aria-controls="return-batch-pane"
                aria-selected="true"
            >
                ISBN連続返却
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="return-single-tab"
                data-bs-toggle="tab"
                data-bs-target="#return-single-pane"
                type="button"
                role="tab"
                aria-controls="return-single-pane"
                aria-selected="false"
            >
                個別返却
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div
            class="tab-pane fade show active"
            id="return-batch-pane"
            role="tabpanel"
            aria-labelledby="return-batch-tab"
        >
            <div class="mb-3">
                <h2 class="h4 fw-bold mb-2">ISBN連続返却</h2>
                <p class="text-secondary mb-0">
                    ISBNを最大10冊まで続けて読み取り、返却対象を一覧で確認できます。
                </p>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <label for="return-batch-isbn" class="form-label fw-semibold">ISBNバーコード</label>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="return-batch-isbn"
                            placeholder="スキャナーで読み取ってください"
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
                                <th scope="col">確認状況</th>
                                <th scope="col">操作</th>
                            </tr>
                        </thead>
                        <tbody id="return-book-queue">
                            <tr>
                                <td colspan="3" class="text-center text-secondary p-4">
                                    ISBNを読み取ると、ここに返却対象が追加されます。
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3" role="status">
                        返却処理は未接続です。ISBNの読み取りと対象一覧の確認のみ利用できます。
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" disabled>
                            確認した書籍を一括返却
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="tab-pane fade"
            id="return-single-pane"
            role="tabpanel"
            aria-labelledby="return-single-tab"
        >
            <div class="mb-3">
                <h2 class="h4 fw-bold mb-2">個別返却</h2>
                <p class="text-secondary mb-0">
                    書籍と借りた社員の情報を入力します。
                </p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <label for="return-book" class="form-label fw-semibold">
                                書籍名またはISBN <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="return-book"
                                placeholder="書籍名またはISBNを入力してください"
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="return-user" class="form-label fw-semibold">
                                借りた社員 <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="return-user"
                                placeholder="社員名またはメールアドレスを入力してください"
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="returned-at" class="form-label fw-semibold">
                                返却日 <span class="required-mark" aria-hidden="true">*</span><span class="visually-hidden">必須</span>
                            </label>
                            <input
                                type="date"
                                class="form-control"
                                id="returned-at"
                                value="{{ now()->format('Y-m-d') }}"
                            >
                        </div>

                        <div class="col-12">
                            <label for="return-note" class="form-label fw-semibold">備考</label>
                            <textarea
                                class="form-control"
                                id="return-note"
                                rows="5"
                                placeholder="返却に関するメモがあれば入力してください"
                            ></textarea>
                        </div>
                    </div>

                    <div class="alert alert-info mt-4 mb-0" role="status">
                        返却処理は未接続です。入力内容の確認のみ利用できます。
                    </div>

                    <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                        <button type="button" class="btn btn-primary" disabled>
                            返却を登録する
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (() => {
            const isbnInput = document.getElementById('return-batch-isbn');
            const addButton = document.getElementById('add-return-isbn');
            const queueBody = document.getElementById('return-book-queue');
            const queueCount = document.getElementById('return-queue-count');
            const scanStatus = document.getElementById('return-scan-status');
            const queue = [];
            const maxBooks = 10;

            const setScanStatus = (message, isError = false) => {
                scanStatus.textContent = message;
                scanStatus.className = isError
                    ? 'small mt-2 text-danger'
                    : 'small mt-2 text-secondary';
            };

            const renderQueue = () => {
                queueBody.replaceChildren();
                queueCount.textContent = `${queue.length} / ${maxBooks}冊`;
                isbnInput.disabled = queue.length >= maxBooks;
                addButton.disabled = queue.length >= maxBooks;

                if (queue.length === 0) {
                    const row = document.createElement('tr');
                    const cell = document.createElement('td');
                    cell.colSpan = 3;
                    cell.className = 'text-center text-secondary p-4';
                    cell.textContent = 'ISBNを読み取ると、ここに返却対象が追加されます。';
                    row.appendChild(cell);
                    queueBody.appendChild(row);

                    return;
                }

                queue.forEach((isbn, index) => {
                    const row = document.createElement('tr');
                    const isbnCell = document.createElement('td');
                    const statusCell = document.createElement('td');
                    const actionCell = document.createElement('td');
                    const removeButton = document.createElement('button');

                    isbnCell.textContent = isbn;
                    statusCell.textContent = 'ISBN読み取り済み';
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
                    row.append(isbnCell, statusCell, actionCell);
                    queueBody.appendChild(row);
                });
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

                if (queue.includes(isbn)) {
                    setScanStatus('このISBNはすでに一覧にあります。', true);
                    isbnInput.value = '';
                    isbnInput.focus();
                    return;
                }

                if (queue.length >= maxBooks) {
                    setScanStatus('一度に確認できるのは10冊までです。', true);
                    return;
                }

                queue.push(isbn);
                isbnInput.value = '';
                setScanStatus('ISBNを追加しました。続けてスキャンできます。');
                renderQueue();
                isbnInput.focus();
            };

            isbnInput.addEventListener('keydown', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    addScannedIsbn();
                }
            });

            addButton.addEventListener('click', addScannedIsbn);
            document.getElementById('return-batch-tab').addEventListener('shown.bs.tab', () => {
                isbnInput.focus();
            });

            renderQueue();
            isbnInput.focus();
        })();
    </script>

@endsection
