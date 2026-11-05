@extends('admin.layouts.app')

@section('title', 'Nuevo usuario')
@section('heading', 'Nuevo usuario')

@section('content')
    <div class="admin-page-intro"><a class="admin-back-link" href="{{ route('admin.users.index') }}">← Volver a usuarios</a><span class="admin-eyebrow">Gestión de acceso</span><h2>Crear un usuario</h2><p>Esta persona tendrá acceso al panel administrativo.</p></div>
    @include('admin.users.partials.form', ['formAction' => route('admin.users.store'), 'formMethod' => 'POST', 'submitLabel' => 'Crear usuario'])
@endsection
