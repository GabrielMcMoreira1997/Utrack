@extends('layouts.admin')

@section('title', 'Nova Tag')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header"><h3 class="card-title">Nova Tag</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('tags.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Descrição</label>
                        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="{{ route('tags.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
