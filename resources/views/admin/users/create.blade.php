@extends('layouts.admin')

@section('title', 'Novo Usuário')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header"><h3 class="card-title">Novo Usuário</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Senha</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" class="form-control" required>
                            <option value="">-- Selecione --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Salvar</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
