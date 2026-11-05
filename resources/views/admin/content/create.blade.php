@extends('admin.layouts.app')

@section('title', 'Nuevo contenido')
@section('heading', 'Nuevo contenido')

@section('content')
    <div class="admin-page-intro"><a class="admin-back-link" href="{{ route('admin.content.index') }}">← Volver a contenido</a><span class="admin-eyebrow">Gestor del sitio</span><h2>Crear contenido</h2><p>Completa la información que se mostrará en la página pública.</p></div>
    @include('admin.content.partials.form', ['formAction' => route('admin.content.store'), 'formMethod' => 'POST', 'submitLabel' => 'Crear contenido'])
@endsection
