@extends('admin.layouts.app')

@section('title', 'Nuevo servicio')
@section('heading', 'Nuevo servicio')

@section('content')
    <div class="admin-page-intro">
        <a class="admin-back-link" href="{{ route('admin.services.index') }}">← Volver a servicios</a>
        <span class="admin-eyebrow">Gestor del sitio</span>
        <h2>Crear un servicio</h2>
        <p>Define la información que aparecerá en la sección de servicios y en su página de detalle.</p>
    </div>

    @include('admin.services.partials.form', [
        'formAction' => route('admin.services.store'),
        'formMethod' => 'POST',
        'submitLabel' => 'Crear servicio',
    ])
@endsection
