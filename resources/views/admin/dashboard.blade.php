@extends('admin.layouts.app')

@section('title', 'Resumen')
@section('heading', 'Resumen')

@section('content')
    <div class="admin-welcome"><div><span class="admin-eyebrow">Hoy, {{ now()->translatedFormat('d \d\e F \d\e Y') }}</span><h2>Todo bajo control.</h2><p>Desde aquí podrás administrar el acceso y la configuración del sitio.</p></div><i data-lucide="sparkles" class="admin-welcome-icon"></i></div>
    <div class="admin-stats"><article class="admin-stat-card"><span class="admin-stat-label">Administradores</span><strong>{{ $administratorsCount }}</strong><span class="admin-stat-meta">con acceso al panel</span></article><article class="admin-stat-card"><span class="admin-stat-label">Estado del sitio</span><strong class="admin-online">Activo</strong><span class="admin-stat-meta">operando con normalidad</span></article></div>
    <div class="admin-section-heading"><div><span class="admin-eyebrow">Gestión de acceso</span><h3>Usuarios</h3></div><a class="admin-button admin-button-secondary" href="{{ route('admin.users.create') }}">Nuevo usuario <i data-lucide="plus" class="admin-button-icon"></i></a></div>
    <div class="admin-empty-card"><div class="admin-empty-icon"><i data-lucide="user-round-plus"></i></div><div><h3>Usuarios administrativos</h3><p>Consulta y administra las cuentas que tienen acceso al panel.</p></div><a href="{{ route('admin.users.index') }}">Ver usuarios <i data-lucide="arrow-right" class="admin-button-icon"></i></a></div>
@endsection
