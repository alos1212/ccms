@extends('admin.layouts.app')

@section('title', 'Usuarios')
@section('heading', 'Usuarios')

@section('content')
    <div class="admin-page-intro admin-page-intro-row"><div><span class="admin-eyebrow">Gestión de acceso</span><h2>Usuarios</h2><p>Administra las cuentas con acceso al panel administrativo.</p></div><a class="admin-button admin-button-primary" href="{{ route('admin.users.create') }}">Nuevo usuario <i data-lucide="plus" class="admin-button-icon"></i></a></div>
    @if (session('status')) <div class="admin-alert admin-alert-success">{{ session('status') }}</div> @endif
    <div class="admin-panel admin-table-wrap"><table class="admin-table"><thead><tr><th>Usuario</th><th>Nombre</th><th>Correo</th><th>Acceso</th><th></th></tr></thead><tbody>@forelse ($users as $user)<tr><td><strong>{{ $user->username }}</strong></td><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td><span class="admin-badge">Administrador</span></td><td class="admin-table-action"><a href="{{ route('admin.users.edit', $user) }}">Editar →</a></td></tr>@empty<tr><td colspan="5" class="admin-table-empty">Todavía no hay usuarios administrativos.</td></tr>@endforelse</tbody></table></div>
@endsection
