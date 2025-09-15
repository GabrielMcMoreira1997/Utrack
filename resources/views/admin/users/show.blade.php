@extends('layouts.admin')

@section('title', 'Detalhes do Usuário')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header"><h3 class="card-title">Detalhes do Usuário</h3></div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Nome:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ $user->role->name ?? '-' }}</p>
                <p><strong>Criado em:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Atualizado em:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">Voltar</a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Editar</a>
            </div>
        </div>

    </div>
</section>
@endsection
