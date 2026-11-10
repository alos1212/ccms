<form class="admin-panel admin-form admin-content-form" method="POST" action="{{ $formAction }}" enctype="multipart/form-data">
    @csrf
    @if ($formMethod !== 'POST')
        @method($formMethod)
    @endif

    <div class="admin-form-section admin-description-section">
        <div class="admin-form-section-title"><i data-lucide="type"></i><div><strong>Información principal</strong><small>El contenido que verá tu audiencia.</small></div></div>
        <div class="admin-form-grid">
            <div><label for="title">Título</label><input id="title" name="title" type="text" value="{{ old('title', $content->title ?? '') }}" required placeholder="Título del contenido">@error('title')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
            <div><label for="subtitle">Subtítulo</label><input id="subtitle" name="subtitle" type="text" value="{{ old('subtitle', $content->subtitle ?? '') }}" placeholder="Una frase complementaria">@error('subtitle')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
            <div><label for="icon">Icono opcional</label><input id="icon" name="icon" type="text" value="{{ old('icon', $content->icon ?? '') }}" placeholder="fa-leaf">@error('icon')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
            <div class="admin-form-full"><label for="introduction">Introducción</label><textarea id="introduction" name="introduction" rows="3" placeholder="Texto breve para presentar el contenido">{{ old('introduction', $content->introduction ?? '') }}</textarea>@error('introduction')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
            <div class="admin-form-full admin-description-field">
                <label for="description-editor">Descripción</label>
                <div id="description-editor" class="admin-rich-editor"></div>
                <textarea id="description" name="description" hidden>{{ old('description', $content->description ?? '') }}</textarea>
                @error('description')<span class="admin-field-error">{{ $message }}</span>@enderror
            </div>
        </div>
    </div>

    <div class="admin-form-section">
        <div class="admin-form-section-title"><i data-lucide="layout-list"></i><div><strong>Ubicación y orden</strong><small>Define dónde aparecerá este contenido.</small></div></div>
        <div class="admin-form-grid">
            <div><label for="section">Sección</label><select id="section" name="section" required>@foreach ($sections as $key => $label)<option value="{{ $key }}" @selected(old('section', $content->section ?? '') === $key)>{{ $label }}</option>@endforeach</select>@error('section')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
            <div><label for="sort_order">Orden</label><input id="sort_order" name="sort_order" type="number" min="1" value="{{ old('sort_order', $content->sort_order ?? '') }}" placeholder="Automático">@error('sort_order')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
        </div>
    </div>

    <div class="admin-form-section">
        <div class="admin-form-section-title"><i data-lucide="image"></i><div><strong>Imagen</strong><small>Formatos JPG, PNG o WebP. Máximo 5 MB.</small></div></div>
        <label class="admin-upload" for="image"><i data-lucide="upload"></i><span>Seleccionar imagen</span><small>Haz clic para buscar un archivo</small><input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"></label>
        @if (isset($content) && $content->image)
            <div class="admin-current-image"><img src="{{ asset('storage/'.$content->image) }}" alt="Imagen actual"><span>Imagen actual</span></div>
        @endif
        @error('image')<span class="admin-field-error">{{ $message }}</span>@enderror
    </div>

    <div class="admin-form-section">
        <div class="admin-form-section-title"><i data-lucide="link"></i><div><strong>Enlace opcional</strong><small>Añade un destino si este contenido debe llevar a otra página.</small></div></div>
        <div class="admin-form-grid">
            <div><label for="link_label">Texto del enlace</label><input id="link_label" name="link_label" type="text" value="{{ old('link_label', $content->link_label ?? '') }}" placeholder="Leer más">@error('link_label')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
            <div class="admin-form-full"><label for="url">URL o ancla</label><input id="url" name="url" type="text" value="{{ old('url', $content->url ?? '') }}" placeholder="https://ejemplo.com o #contact">@error('url')<span class="admin-field-error">{{ $message }}</span>@enderror</div>
            <label class="admin-checkbox"><input name="open_in_new_tab" type="checkbox" value="1" @checked(old('open_in_new_tab', $content->open_in_new_tab ?? false))><span>Abrir enlace en una nueva pestaña</span></label>
        </div>
    </div>

    <div class="admin-form-section admin-form-section-last"><label class="admin-checkbox"><input name="is_active" type="checkbox" value="1" @checked(old('is_active', $content->is_active ?? true))><span>Contenido activo y visible en el sitio</span></label></div>
    <div class="admin-form-actions"><a class="admin-button admin-button-ghost" href="{{ route('admin.content.index') }}">Cancelar</a><button class="admin-button admin-button-primary" type="submit">{{ $submitLabel }} <i data-lucide="arrow-right" class="admin-button-icon"></i></button></div>
</form>

<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script src="https://cdn.jsdelivr.net/npm/resize-quill-image@1.0.10/dist/index.iife.js"></script>
<script>
    const descriptionSource = document.getElementById('description');
    Quill.register('modules/imageResize', ImageResize);

    const imageUploadHandler = () => {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/jpeg,image/png,image/webp,image/gif';
        input.click();
        input.addEventListener('change', async () => {
            const file = input.files?.[0];
            if (!file) return;
            const formData = new FormData();
            formData.append('image', file);
            const response = await fetch('{{ route('admin.content.images.store') }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                body: formData,
            });
            const result = await response.json();
            if (!response.ok) {
                alert(result.message || 'No fue posible cargar la imagen.');
                return;
            }
            const range = descriptionEditor.getSelection(true);
            descriptionEditor.insertEmbed(range.index, 'image', result.url, 'user');
            descriptionEditor.setSelection(range.index + 1, 0);
        });
    };

    const descriptionEditor = new Quill('#description-editor', {
        theme: 'snow',
        placeholder: 'Escribe y diseña la descripción del contenido...',
        modules: {
            imageResize: { modules: ['Resize', 'DisplaySize', 'Toolbar'] },
            toolbar: [
                [{ header: [1, 2, 3, false] }],
                [{ font: [] }, { size: ['small', false, 'large', 'huge'] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ color: [] }, { background: [] }],
                [{ align: [] }],
                [{ list: 'ordered' }, { list: 'bullet' }, { indent: '-1' }, { indent: '+1' }],
                ['blockquote', 'code-block', 'link', 'image'],
                ['clean'],
            ],
        },
    });

    descriptionEditor.getModule('toolbar').addHandler('image', imageUploadHandler);

    if (descriptionSource.value) {
        descriptionEditor.clipboard.dangerouslyPasteHTML(descriptionSource.value);
    }

    document.querySelector('.admin-content-form').addEventListener('submit', () => {
        descriptionSource.value = descriptionEditor.root.innerHTML;
    });
</script>
