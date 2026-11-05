@extends('admin.layouts.app')

@section('title', 'Editar usuario')
@section('heading', 'Editar usuario')

@section('content')
    <div class="admin-page-intro"><a class="admin-back-link" href="{{ route('admin.users.index') }}">← Volver a usuarios</a><span class="admin-eyebrow">Gestión de acceso</span><h2>Editar usuario</h2><p>Actualiza los datos de acceso de {{ $user->username }}.</p></div>
    @include('admin.users.partials.form', ['formAction' => route('admin.users.update', $user), 'formMethod' => 'PUT', 'submitLabel' => 'Guardar cambios', 'user' => $user])
@endsection
