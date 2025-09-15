@extends('layouts.admin')

@section('title', 'Editar Tag')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Editar Tag</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('tags.update', $tag->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description', $tag->description) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Atualizar</button>
                    <a href="{{ route('tags.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
