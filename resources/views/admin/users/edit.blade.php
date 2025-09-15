@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
<section class="content pt-3">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header"><h3 class="card-title">Editar Usuário</h3></div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Senha (deixe em branco para não alterar)</label>
                        <input type="password" name="password" class="form-control">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id" class="form-control" required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-success">Atualizar</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>

    </div>
</section>
@endsection
