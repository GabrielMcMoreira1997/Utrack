@extends('layouts.admin')

@section('title', 'Tags')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Tags</h3>
                <a href="{{ route('tags.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nova Tag
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->name }}</td>
                            <td>{{ $tag->description }}</td>
                            <td>
                                <a href="{{ route('tags.show', $tag->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir esta tag?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">{{ $tags->links() }}</div>
            </div>
        </div>

    </div>
</section>
@endsection
