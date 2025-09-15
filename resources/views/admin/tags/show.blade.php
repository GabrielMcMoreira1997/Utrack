@extends('layouts.admin')

@section('title', 'Detalhes da Tag')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Detalhes da Tag</h3></div>
            <div class="card-body">
                <p><strong>ID:</strong> {{ $tag->id }}</p>
                <p><strong>Nome:</strong> {{ $tag->name }}</p>
                <p><strong>Descrição:</strong> {{ $tag->description }}</p>
                <p><strong>Criado em:</strong> {{ $tag->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Atualizado em:</strong> {{ $tag->updated_at->format('d/m/Y H:i') }}</p>

                <a href="{{ route('tags.index') }}" class="btn btn-secondary">Voltar</a>
                <a href="{{ route('tags.edit', $tag->id) }}" class="btn btn-warning">Editar</a>
            </div>
        </div>
    </div>
</section>
@endsection
