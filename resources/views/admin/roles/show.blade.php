@extends('layouts.admin')

@section('title', 'Detalhes da Role')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Detalhes da Role</h3></div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $role->id }}</p>
                <p><strong>Nome:</strong> {{ $role->name }}</p>
                <p><strong>Slug:</strong> {{ $role->slug }}</p>
                <p><strong>Criado em:</strong> {{ $role->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Atualizado em:</strong> {{ $role->updated_at->format('d/m/Y H:i') }}</p>

                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Voltar</a>
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">Editar</a>
            </div>
        </div>
    </div>
</section>
@endsection
