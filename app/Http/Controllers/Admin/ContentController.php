<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContentController extends Controller
{
    /**
     * Edit this list when the public site gets new content sections.
     */
    protected function sections(): array
    {
        return [
            'hero' => 'Hero / portada',
            'about' => 'Nosotros',
            'services' => 'Servicios',
            'portfolio' => 'Portafolio',
            'contact' => 'Contacto',
        ];
    }

    public function index(): View
    {
        return view('admin.content.index', [
            'contents' => Content::query()->orderBy('section')->orderBy('sort_order')->orderBy('id')->get(),
            'sections' => $this->sections(),
        ]);
    }

    public function create(): View
    {
        return view('admin.content.create', ['sections' => $this->sections()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = $this->storeImage($request);
        $data['sort_order'] = $data['sort_order'] ?? $this->nextOrder($data['section']);

        Content::create($data);

        return redirect()->route('admin.content.index')->with('status', 'Contenido creado correctamente.');
    }

    public function edit(Content $content): View
    {
        return view('admin.content.edit', [
            'content' => $content,
            'sections' => $this->sections(),
        ]);
    }

    public function update(Request $request, Content $content): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($content->image) {
                Storage::disk('public')->delete($content->image);
            }
            $data['image'] = $this->storeImage($request);
        }

        $content->update($data);

        return redirect()->route('admin.content.index')->with('status', 'Contenido actualizado correctamente.');
    }

    public function move(Request $request, Content $content): RedirectResponse
    {
        $direction = $request->validate(['direction' => ['required', 'in:up,down']])['direction'];
        $query = Content::query()->where('section', $content->section);
        $neighbor = $direction === 'up'
            ? $query->where(function ($query) use ($content): void {
                $query->where('sort_order', '<', $content->sort_order)
                    ->orWhere(function ($query) use ($content): void {
                        $query->where('sort_order', $content->sort_order)->where('id', '<', $content->id);
                    });
            })->orderByDesc('sort_order')->orderByDesc('id')->first()
            : $query->where(function ($query) use ($content): void {
                $query->where('sort_order', '>', $content->sort_order)
                    ->orWhere(function ($query) use ($content): void {
                        $query->where('sort_order', $content->sort_order)->where('id', '>', $content->id);
                    });
            })->orderBy('sort_order')->orderBy('id')->first();

        if ($neighbor) {
            [$content->sort_order, $neighbor->sort_order] = [$neighbor->sort_order, $content->sort_order];
            $content->save();
            $neighbor->save();
        }

        return back();
    }

    public function uploadImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        $path = $request->file('image')->store('content/editor', 'public');

        return response()->json(['url' => asset('storage/'.$path)]);
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'introduction' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'section' => ['required', 'string', 'in:'.implode(',', array_keys($this->sections()))],
            'url' => ['nullable', 'url', 'max:2048'],
            'open_in_new_tab' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['open_in_new_tab'] = $request->boolean('open_in_new_tab');
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    protected function storeImage(Request $request): ?string
    {
        return $request->hasFile('image') ? $request->file('image')->store('content', 'public') : null;
    }

    protected function nextOrder(string $section): int
    {
        return ((int) Content::query()->where('section', $section)->max('sort_order')) + 1;
    }
}
