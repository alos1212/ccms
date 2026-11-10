@extends('admin.layouts.app')

@section('title', 'Editar servicio')
@section('heading', 'Editar servicio')

@section('content')
    <div class="admin-page-intro">
        <a class="admin-back-link" href="{{ route('admin.services.index') }}">← Volver a servicios</a>
        <span class="admin-eyebrow">Gestor del sitio</span>
        <h2>Editar servicio</h2>
        <p>Actualiza la información de “{{ $service->title }}” sin cambiar su dirección pública accidentalmente.</p>
    </div>

    @include('admin.services.partials.form', [
        'formAction' => route('admin.services.update', $service),
        'formMethod' => 'PUT',
        'submitLabel' => 'Guardar cambios',
        'service' => $service,
    ])
@endsection
