@extends('layouts.admin')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="fw-bold text-dark mb-4">Monitoramento em Tempo Real</h2>

    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>Log de acessos</span>
            <span>Cliques: <strong id="click-counter">0</strong></span>
        </div>

        <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
            <ul id="access-log" class="list-group list-group-flush">
                {{-- Eventos em tempo real aparecerão aqui --}}
            </ul>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Truncar URLs longas para não quebrar layout */
    .list-group-item strong {
        display: inline-block;
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@endpush
@endsection
