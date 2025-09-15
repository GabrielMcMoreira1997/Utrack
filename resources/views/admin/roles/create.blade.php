@extends('layouts.admin')

@section('title', 'Nova Role')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header"><h3 class="card-title">Nova Role</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="form-control" required>
                        @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
