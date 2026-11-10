@extends('admin.layouts.app')

@section('title', 'Servicios')
@section('heading', 'Servicios')

@section('content')
    <div class="admin-page-intro admin-page-intro-row">
        <div>
            <span class="admin-eyebrow">Gestor del sitio</span>
            <h2>Servicios</h2>
            <p>Administra cada servicio, su imagen, icono y página de detalle.</p>
        </div>
        <a class="admin-button admin-button-primary" href="{{ route('admin.services.create') }}">
            Nuevo servicio <i data-lucide="plus" class="admin-button-icon"></i>
        </a>
    </div>

    @if (session('status'))
        <div class="admin-alert admin-alert-success">{{ session('status') }}</div>
    @endif

    <div class="admin-panel admin-table-wrap">
        <table class="admin-table admin-services-table">
            <thead>
                <tr>
                    <th>Orden</th>
                    <th>Servicio</th>
                    <th>URL de detalle</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>
                            <div class="admin-order-controls">
                                <form method="POST" action="{{ route('admin.services.move', $service) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="up">
                                    <button type="submit" title="Subir" @disabled($loop->first)><i data-lucide="chevron-up"></i></button>
                                </form>
                                <strong>{{ $service->sort_order }}</strong>
                                <form method="POST" action="{{ route('admin.services.move', $service) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="down">
                                    <button type="submit" title="Bajar" @disabled($loop->last)><i data-lucide="chevron-down"></i></button>
                                </form>
                            </div>
                        </td>
                        <td>
                            <div class="admin-content-cell admin-service-cell">
                                @if ($service->image)
                                    <img src="{{ asset('storage/'.$service->image) }}" alt="">
                                @else
                                    <span class="admin-content-placeholder"><i class="fa-solid {{ $service->icon ?: 'fa-building' }}"></i></span>
                                @endif
                                <div>
                                    <strong>{{ $service->title }}</strong>
                                    <small>{{ $service->subtitle ?: 'Sin subtítulo' }}</small>
                                    <span class="admin-service-slug">/{{ $service->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a class="admin-service-url" href="{{ route('services.show', $service) }}" target="_blank" rel="noopener">
                                /services/{{ $service->slug }} <i data-lucide="external-link"></i>
                            </a>
                        </td>
                        <td>
                            <span class="admin-status-badge {{ $service->is_active ? 'is-active' : 'is-inactive' }}">
                                {{ $service->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="admin-table-action">
                            <a href="{{ route('admin.services.edit', $service) }}">Editar <i data-lucide="arrow-right" class="admin-button-icon"></i></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="admin-table-empty">Todavía no hay servicios creados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
