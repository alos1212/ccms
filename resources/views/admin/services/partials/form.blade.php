<form class="admin-panel admin-form admin-service-form" method="POST" action="{{ $formAction }}" enctype="multipart/form-data">
    @csrf
    @if ($formMethod !== 'POST')
        @method($formMethod)
    @endif

    <div class="admin-form-section">
        <div class="admin-form-section-title">
            <i data-lucide="briefcase-business"></i>
            <div><strong>Información principal</strong><small>El nombre y la presentación del servicio.</small></div>
        </div>
        <div class="admin-form-grid">
            <div>
                <label for="title">Título</label>
                <input id="title" name="title" type="text" value="{{ old('title', $service->title ?? '') }}" required placeholder="Commercial Facility Services">
                @error('title')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="subtitle">Subtítulo</label>
                <input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $service->subtitle ?? '') }}" placeholder="Spaces that work better.">
                @error('subtitle')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="slug">URL limpia</label>
                <div class="admin-slug-input"><span>/services/</span><input id="slug" name="slug" type="text" value="{{ old('slug', $service->slug ?? '') }}" required placeholder="commercial-facility-services" spellcheck="false"></div>
                <small class="admin-field-help">Usa minúsculas, números y guiones. Ejemplo: <strong>construction-cleaning</strong>.</small>
                @error('slug')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
            <div>
                <label for="icon">Icono Font Awesome</label>
                <div class="admin-icon-input"><i id="service-icon-preview" class="fa-solid {{ old('icon', $service->icon ?? 'fa-building') }}"></i><input id="icon" name="icon" type="text" value="{{ old('icon', $service->icon ?? 'fa-building') }}" placeholder="fa-building" spellcheck="false"></div>
                <small class="admin-field-help">Escribe el nombre de un icono, por ejemplo: <strong>fa-building</strong> o <strong>fa-droplet</strong>.</small>
                @error('icon')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
            <div class="admin-form-full">
                <label for="introduction">Introducción</label>
                <textarea id="introduction" name="introduction" rows="3" placeholder="Texto breve para presentar el servicio">{{ old('introduction', $service->introduction ?? '') }}</textarea>
                @error('introduction')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
            <div class="admin-form-full admin-description-field">
                <label for="description-editor">Descripción completa</label>
                <div id="description-editor" class="admin-rich-editor"></div>
                <textarea id="description" name="description" hidden>{{ old('description', $service->description ?? '') }}</textarea>
                @error('description')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="admin-form-section">
        <div class="admin-form-section-title">
            <i data-lucide="image"></i>
            <div><strong>Imagen del servicio</strong><small>Formatos JPG, PNG o WebP. Máximo 5 MB.</small></div>
        </div>
        <label class="admin-upload" for="image">
            <i data-lucide="upload"></i><span>Seleccionar imagen</span><small>Haz clic para buscar un archivo</small>
            <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
        </label>
        @if (isset($service) && $service->image)
            <div class="admin-current-image"><img src="{{ asset('storage/'.$service->image) }}" alt="Imagen actual"><span>Imagen actual</span></div>
        @endif
        @error('image')<span class="admin-field-error">{{ $message }}</span>@enderror
    </div>

    <div class="admin-form-section admin-service-settings">
        <div class="admin-form-grid">
            <div>
                <label for="sort_order">Orden de aparición</label>
                <input id="sort_order" name="sort_order" type="number" min="1" value="{{ old('sort_order', $service->sort_order ?? '') }}" placeholder="Automático">
                @error('sort_order')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
            <label class="admin-checkbox admin-service-active"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $service->is_active ?? true))><span>Servicio activo y visible en el sitio</span></label>
        </div>
    </div>

    <div class="admin-form-actions">
        <a class="admin-button admin-button-ghost" href="{{ route('admin.services.index') }}">Cancelar</a>
        <button class="admin-button admin-button-primary" type="submit">{{ $submitLabel }} <i data-lucide="arrow-right" class="admin-button-icon"></i></button>
    </div>
</form>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    const serviceTitle = document.getElementById('title');
    const serviceSlug = document.getElementById('slug');
    const serviceIcon = document.getElementById('icon');
    const serviceIconPreview = document.getElementById('service-icon-preview');
    let slugWasEdited = Boolean(serviceSlug.value);

    serviceTitle?.addEventListener('input', () => {
        if (slugWasEdited) return;
        serviceSlug.value = serviceTitle.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '');
    });
    serviceSlug?.addEventListener('input', () => { slugWasEdited = true; });
    serviceIcon?.addEventListener('input', () => {
        serviceIconPreview.className = `fa-solid ${serviceIcon.value || 'fa-building'}`;
    });

    const serviceDescriptionSource = document.getElementById('description');
    const serviceDescriptionEditor = new Quill('#description-editor', {
        theme: 'snow',
        placeholder: 'Describe el alcance, beneficios y características del servicio...',
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                [{ font: [] }, { size: ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ align: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
                ['blockquote', 'link'],
                ['clean'],
            ],
        },
    });

    if (serviceDescriptionSource.value) {
        serviceDescriptionEditor.clipboard.dangerouslyPasteHTML(serviceDescriptionSource.value);
    }

    document.querySelector('.admin-service-form').addEventListener('submit', () => {
        serviceDescriptionSource.value = serviceDescriptionEditor.root.innerHTML;
    });
</script>
