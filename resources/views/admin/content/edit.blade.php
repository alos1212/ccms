@extends('admin.layouts.app')

@section('title', 'Editar contenido')
@section('heading', 'Editar contenido')

@section('content')
    <div class="admin-page-intro"><a class="admin-back-link" href="{{ route('admin.content.index') }}">← Volver a contenido</a><span class="admin-eyebrow">Gestor del sitio</span><h2>Editar contenido</h2><p>Actualiza la información de “{{ $content->title }}”.</p></div>
    @include('admin.content.partials.form', ['formAction' => route('admin.content.update', $content), 'formMethod' => 'PUT', 'submitLabel' => 'Guardar cambios', 'content' => $content])
@endsection
