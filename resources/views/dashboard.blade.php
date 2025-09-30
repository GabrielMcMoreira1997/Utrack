@extends('layouts.admin')

@section('content')
    <div class="container-fluid mt-4">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">
                <i class="fas fa-link text-success me-2"></i> Links Criados
            </h2>
            <a href="#" class="btn btn-success shadow-sm create-edit-link" data-bs-toggle="modal"
                data-bs-target="#createLinkModal" data-action="{{ route('shorten') }}">
                <i class="fas fa-plus-circle me-1"></i> Criar Link
            </a>
        </div>

        {{-- Filtros --}}
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body">
                <form id="filterForm" class="row g-3">
                    <div class="col-md-3">
                        <label for="filterAuthor" class="form-label">Autor</label>
                        <select id="filterAuthor" class="form-select tom-select">
                            <option value="">Todos</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterRole" class="form-label">Role</label>
                        <select id="filterRole" class="form-select tom-select">
                            <option value="">Todos</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterTags" class="form-label">Tags</label>
                        <select id="filterTags" class="form-select tom-select" multiple>
                            @foreach($allTags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Data de Criação</label>
                        <div class="d-flex gap-2">
                            <input type="date" id="filterStart" class="form-control">
                            <input type="date" id="filterEnd" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end mt-2">
                        <button type="button" id="resetFilters" class="btn btn-outline-secondary mx-2">Limpar</button>
                        <button type="button" id="applyFilters" class="btn btn-success">Aplicar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                @if($links->count())
                    <div class="table-responsive p-3">
                        <table id="linksTable" class="table table-striped table-hover align-middle w-100">
                            <thead class="table-light">
                                <tr>
                                    <th>Link Curto</th>
                                    <th>URL Original</th>
                                    <th>Descrição</th>
                                    <th>Clicks</th>
                                    <th>Criado</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($links as $link)
                                    <tr data-tags='@json($link->tags->pluck("id"))' data-author-id="{{ $link->author_id }}"
                                        data-role="{{ $link->author->role->name ?? '' }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ $link->company->domain . '/' . $link->short_code }}" target="_blank"
                                                    class="text-success fw-semibold text-decoration-none">
                                                    {{ $link->company->domain . '/' . $link->short_code }}
                                                </a>
                                                <button class="btn btn-sm btn-outline-secondary ms-2"
                                                    onclick="copyToClipboard('{{ $link->company->domain . '/' . $link->short_code }}')"
                                                    title="Copiar">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-muted">{{ Str::limit($link->original_url, 80) }}</td>
                                        <td class="text-muted">{{ Str::limit($link->description, 80) }}</td>
                                        <td class="fw-bold text-center">
                                            <span class="badge bg-success">{{ $link->clicks }}</span>
                                        </td>
                                        <td class="text-muted">{{ $link->created_at->diffForHumans() }}</td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-sm btn-outline-primary edit-link-btn"
                                                    data-id="{{ $link->id }}" data-url="{{ $link->original_url }}"
                                                    data-short_code="{{ $link->short_code }}" data-expire="{{ $link->expire_at }}"
                                                    data-tags='@json($link->tags->pluck("id"))'
                                                    data-password="{{ $link->password ?? '' }}"
                                                    data-description="{{ $link->description ?? ''}}"
                                                    data-action="{{ route('links.edit', $link) }}" title="Editar">
                                                    <i class="fas fa-edit create-edit-link"></i>
                                                </a>

                                                <form action="{{ route('links.destroy', $link) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Tem certeza que deseja excluir este link?')"
                                                        title="Excluir">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-5 text-center text-muted">
                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                        <p class="mb-2">Nenhum link criado ainda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('admin.links.create')

    {{-- DataTables + Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

        {{-- Tom Select --}}
        <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

        <script>
            let tagsSelect = null;
            let qrTimeout;
            let lastUrl = '';
            let lastShortCode = '';

            document.addEventListener("DOMContentLoaded", function () {
                // Inicializa TomSelect
                const el = document.querySelector("#tags");
                if (el) {
                    tagsSelect = new TomSelect(el, {
                        create: true,
                        persist: false,
                        plugins: ['remove_button'],
                        delimiter: ',',
                        placeholder: 'Digite para buscar ou criar tags...'
                    });
                }

                // Inicializa tooltips
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
            });

            // Função global para copiar link
            window.copyToClipboard = function (text) {
                navigator.clipboard.writeText(text).then(() => {
                    const toast = document.createElement('div');
                    toast.textContent = 'Link copiado para a área de transferência!';
                    toast.className = 'toast-notification';
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 2000);
                });
            }

            // Função para atualizar QR Code
            function updateQRCode(shortCode) {
                const domain = $('#domain').text().replace(/\/$/, '');
                if (shortCode) {
                    const finalUrl = domain + '/' + shortCode;
                    $('#qrCodePreview').html('<video src="/images/loading.webm" autoplay loop muted style="width:48px;height:48px;"></video>');
                    $.ajax({
                        url: '{{ route("generate.qr") }}',
                        method: 'POST',
                        data: { url: finalUrl, _token: '{{ csrf_token() }}' },
                        success: function (data) { $('#qrCodePreview').html(data.qr); },
                        error: function () { $('#qrCodePreview').html('<span class="text-danger">Erro ao gerar QR Code</span>'); }
                    });
                } else { $('#qrCodePreview').html('<span class="text-muted">[ Preview QR ]</span>'); }
            }

            $(document).ready(function () {
                // DataTable
                var table = $('#linksTable').DataTable({
                    pageLength: 10,
                    order: [[3, 'desc']],
                    language: { url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/pt-BR.json" }
                });

                document.querySelectorAll('.tom-select').forEach(el => {
                    new TomSelect(el, {
                        create: false,
                        persist: false,
                        plugins: ['remove_button'],
                        placeholder: 'Selecione...',
                    });
                });

                $(document).on('click', '.create-edit-link', function () {
                    const action = $(this).data('action');
                    $('#createLinkForm').attr('action', action).attr('method', 'POST');
                    $('#createLinkModal').modal('show'); // Ensure modal opens
                });

                // Editar link
                $(document).on('click', '.edit-link-btn', function (e) {
                    e.preventDefault();
                    const linkId = $(this).data('id');
                    const url = $(this).data('url');
                    const shortCode = $(this).data('short_code');
                    const expireAt = $(this).data('expire');
                    const tags = $(this).data('tags') || [];
                    const password = $(this).data('password') || '';
                    const description = $(this).data('description') || '';

                    const modal = $('#createLinkModal');
                    modal.modal('show');
                    modal.find('.modal-title').text('Editar Link');
                    modal.find('button[type="submit"]').text('Atualizar Link');

                    modal.find('#url').val(url).prop('readonly', true);
                    modal.find('#short_code').val(shortCode);
                    modal.find('#expire_at').val(expireAt);
                    modal.find('#password').val(password);
                    modal.find('textarea[name="description"]').val(description);

                    if (tagsSelect) { tagsSelect.clear(); tags.forEach(id => tagsSelect.addItem(id)); }

                    updateQRCode(shortCode);

                    // Edit URL + method spoofing
                    let editUrl = '{{ route("links.edit", ":id") }}'.replace(':id', linkId);
                    $('#createLinkForm').attr('action', editUrl).attr('method', 'POST');
                    if ($('#createLinkForm').find('input[name="_method"]').length === 0) {
                        $('#createLinkForm').append('<input type="hidden" name="_method" value="PUT">');
                    } else {
                        $('#createLinkForm').find('input[name="_method"]').val('PUT');
                    }
                });

                // Limpar modal ao criar novo link
                $('#createLinkModal').on('show.bs.modal', function () {
                    const modal = $(this);
                    if (!modal.hasClass('editing')) {
                        modal.find('#url,#short_code,#expire_at,#password').val('');
                        modal.find('#url').prop('readonly', false);
                        if (tagsSelect) tagsSelect.clear();
                        $('#qrCodePreview').html('<span class="text-muted">[ Preview QR ]</span>');
                        modal.find('.modal-title').text('Novo Link');
                        modal.find('button[type="submit"]').text('Criar Link');
                        modal.find('input[name="_method"]').remove();
                        modal.find('textarea[name="description"]').val('');
                    }
                });

                // Input URL / short_code
                $('#url').on('input', function () {
                    clearTimeout(qrTimeout);
                    lastUrl = $(this).val();
                    if (lastUrl) {
                        qrTimeout = setTimeout(() => {
                            $.ajax({
                                url: '{{ route("generate.short_code") }}',
                                method: 'POST',
                                data: { url: lastUrl, _token: '{{ csrf_token() }}' },
                                success: function (data) {
                                    lastShortCode = data.short_code ?? data;
                                    $('#short_code').val(lastShortCode);
                                    updateQRCode(lastShortCode);
                                },
                                error: function () { $('#qrCodePreview').html('<span class="text-danger">Erro ao gerar Short Code</span>'); }
                            });
                        }, 500);
                    } else {
                        $('#short_code').val('');
                        lastShortCode = '';
                        $('#qrCodePreview').html('<span class="text-muted">[ Preview QR ]</span>');
                    }
                });

                $('#short_code').on('input', function () {
                    clearTimeout(qrTimeout);
                    lastShortCode = $(this).val();
                    if (lastShortCode) { qrTimeout = setTimeout(() => updateQRCode(lastShortCode), 500); }
                    else $('#qrCodePreview').html('<span class="text-muted">[ Preview QR ]</span>');
                });

                // Download / copiar QR
                function getQrImageData() {
                    let img = $('#qrCodePreview').find('img');
                    if (img.length) return img.attr('src');
                    let svg = $('#qrCodePreview').find('svg');
                    if (svg.length) {
                        let svgData = new XMLSerializer().serializeToString(svg[0]);
                        return URL.createObjectURL(new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' }));
                    }
                    return null;
                }

                $('#downloadQr').on('click', function (e) {
                    e.preventDefault();
                    let qrData = getQrImageData();
                    if (!qrData) { alert('Nenhum QR Code gerado ainda.'); return; }
                    let link = document.createElement('a'); link.href = qrData; link.download = 'qrcode.png'; document.body.appendChild(link); link.click(); document.body.removeChild(link);
                });

                $('#copyQr').on('click', async function (e) {
                    e.preventDefault();
                    let qrData = getQrImageData();
                    if (!qrData) { alert('Nenhum QR Code gerado ainda.'); return; }
                    try {
                        const response = await fetch(qrData);
                        const blob = await response.blob();
                        await navigator.clipboard.write([new ClipboardItem({ [blob.type]: blob })]);
                        const toast = document.createElement('div');
                        toast.textContent = 'QR Code copiado para a área de transferência!';
                        toast.className = 'toast-notification';
                        document.body.appendChild(toast);
                        setTimeout(() => toast.remove(), 2000);
                    } catch (err) { alert('Falha ao copiar QR Code.'); console.error(err); }
                });

                // Filtro customizado
                $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                    const author = $('#filterAuthor').val();
                    const role = $('#filterRole').val();
                    const tags = $('#filterTags').val() || [];
                    const start = $('#filterStart').val();
                    const end = $('#filterEnd').val();

                    const row = table.row(dataIndex).data();

                    // Data da criação (coluna 4, zero-indexed)
                    const createdAt = row[4] ? new Date(row[4]) : null;
                    const startDate = start ? new Date(start) : null;
                    const endDate = end ? new Date(end) : null;
                    if ((startDate && (!createdAt || createdAt < startDate)) ||
                        (endDate && (!createdAt || createdAt > endDate))) return false;

                    // Autor (você precisa ter o ID do autor em uma coluna oculta ou data-attribute)
                    if (author && $(table.row(dataIndex).node()).data('author-id') != author) return false;

                    // Role (idem autor)
                    if (role && $(table.row(dataIndex).node()).data('role') != role) return false;

                    // Tags (múltiplas) - assume que você armazenou data-tags na <tr> como array JSON
                    if (tags.length) {
                        const rowTags = $(table.row(dataIndex).node()).data('tags') || [];
                        if (!tags.some(tag => rowTags.includes(parseInt(tag)))) return false;
                    }

                    return true;
                });

                // Aplicar filtros
                $('#applyFilters').on('click', function () { table.draw(); });

                // Limpar filtros
                $('#resetFilters').on('click', function () {
                    $('#filterForm').trigger('reset');
                    $('.tom-select').each(function () {
                        if (this.tomselect) this.tomselect.clear();
                    });
                    table.draw();
                });

            });
        </script>
    @endpush
@endsection