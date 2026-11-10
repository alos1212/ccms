<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => Service::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['image'] = $this->storeImage($request);
        $data['sort_order'] = $data['sort_order'] ?? $this->nextOrder();

        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', 'Servicio creado correctamente.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validated($request, $service);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $data['image'] = $this->storeImage($request);
        }

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Servicio actualizado correctamente.');
    }

    public function move(Request $request, Service $service): RedirectResponse
    {
        $direction = $request->validate([
            'direction' => ['required', 'in:up,down'],
        ])['direction'];

        $neighbor = $direction === 'up'
            ? Service::query()
                ->where(function ($query) use ($service): void {
                    $query->where('sort_order', '<', $service->sort_order)
                        ->orWhere(function ($query) use ($service): void {
                            $query->where('sort_order', $service->sort_order)->where('id', '<', $service->id);
                        });
                })
                ->orderByDesc('sort_order')
                ->orderByDesc('id')
                ->first()
            : Service::query()
                ->where(function ($query) use ($service): void {
                    $query->where('sort_order', '>', $service->sort_order)
                        ->orWhere(function ($query) use ($service): void {
                            $query->where('sort_order', $service->sort_order)->where('id', '>', $service->id);
                        });
                })
                ->orderBy('sort_order')
                ->orderBy('id')
                ->first();

        if ($neighbor) {
            [$service->sort_order, $neighbor->sort_order] = [$neighbor->sort_order, $service->sort_order];
            $service->save();
            $neighbor->save();
        }

        return back();
    }

    protected function validated(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:120',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('services', 'slug')->ignore($service?->id),
            ],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'icon' => ['nullable', 'string', 'max:80', 'regex:/^fa-[a-z0-9-]+$/'],
            'introduction' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::lower(trim($data['slug']));
        $data['icon'] = trim($data['icon'] ?? '') ?: null;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    protected function storeImage(Request $request): ?string
    {
        return $request->hasFile('image')
            ? $request->file('image')->store('services', 'public')
            : null;
    }

    protected function nextOrder(): int
    {
        return ((int) Service::query()->max('sort_order')) + 1;
    }
}
