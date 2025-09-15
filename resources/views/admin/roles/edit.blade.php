@extends('layouts.admin')

@section('title', 'Editar Role')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Editar Role</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update', $role->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ old('name', $role->name) }}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $role->slug) }}" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Atualizar</button>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
