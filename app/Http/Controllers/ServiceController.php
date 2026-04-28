<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('name', 'asc')->get();
        return view('services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:services,name',
        ]);

        Service::create($validated);

        return redirect()->route('service.index')
            ->with('success', __('Spécialité ajoutée avec succès'));
    }

    public function show(string $id)
    {
        $service = Service::findOrFail($id);
        return view('services.show', compact('service'));
    }
    public function edit(string $id)
    {
        $service = Service::findOrFail($id);
        return view('services.modify', compact('service'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')->ignore($id),
            ],
        ]);

        $service = Service::findOrFail($id);
        $service->update($validated);

        return redirect()->route('service.index')
            ->with('success', __('Spécialité mise à jour avec succès'));
    }

    public function destroy(string $id)
    {
        $service = Service::findOrFail($id);

        if ($service->rendez_vous()->exists()) {
            return redirect()->route('service.index')
                ->with('error', __('Impossible de supprimer cette spécialité car elle est liée à des rendez-vous.'));
        }

        $service->delete();

        return redirect()->route('service.index')
            ->with('success', __('Spécialité supprimée avec succès'));
    }

    public function search(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where('name', 'like', "%{$term}%");
        }

        return response()->json(
            $query->orderBy('name', 'asc')->get()
        );
    }
}
