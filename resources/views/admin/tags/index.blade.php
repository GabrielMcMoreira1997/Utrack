@extends('layouts.admin')

@section('title', 'Tags')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">

        {{-- Mensagem de sucesso --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Cabeçalho --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">
                <i class="fas fa-tags text-success me-2"></i> Tags
            </h2>
            <a href="{{ route('tags.create') }}" class="btn btn-success shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Nova Tag
            </a>
        </div>

        {{-- Card com a tabela --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                @if($tags->count())
                    <div class="table-responsive p-3">
                        <table id="tagsTable" class="table table-striped table-hover align-middle w-100">
                            <thead style="background-color: #D5F5E3;">
                                <tr>
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tags as $tag)
                                <tr>
                                    <td>{{ $tag->id }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->description }}</td>
                                    <td class="text-end">
                                        <div class="btn-group">
                                            <a href="{{ route('tags.show', $tag->id) }}" class="btn btn-sm btn-outline-success" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" class="d-inline"
                                                  onsubmit="return confirm('Tem certeza que deseja excluir esta tag?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                                    <i class="fas fa-trash"></i>
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
                        <i class="fas fa-tags fa-3x mb-3" style="color: #2ECC71;"></i>
                        <p class="mb-2">Nenhuma tag cadastrada ainda.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Inicializa DataTable
        $('#tagsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            },
            "pageLength": 10,
            "lengthChange": false,
            "ordering": true,
            "columnDefs": [
                { "orderable": false, "targets": 3 } // Ações não ordenáveis
            ]
        });
    });
</script>
@endsection
