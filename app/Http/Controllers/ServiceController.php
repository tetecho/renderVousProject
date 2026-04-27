<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    /**
     * Afficher la liste de toutes les spécialités
     */
    public function index()
    {
        $services = Service::orderBy('nom', 'asc')->get();
        return view('services.index', compact('services'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        // return view('services.create');
    }

    /**
     * Enregistrer une nouvelle spécialité
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required',
        ]);

        // Création de la spécialité
        Service::create($validated);

        return redirect()->route('service.index')
            ->with('success', 'Spécialité ajoutée avec succès');
    }

    /**
     * Afficher les détails d'une spécialité
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(string $id)
    {
        $service = Service::find($id);
        return view('services.edit', compact('service'));
    }

    /**
     * Mettre à jour une spécialité
     */
    public function update(Request $request, string $id)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required',
        ]);
        $Service = Service::find($id);

        // Mise à jour de la spécialité
        $Service->update($validated);

        return redirect()->route('service.index')
            ->with('success', 'Spécialité mise à jour avec succès');
    }

    /**
     * Supprimer une spécialité
     */
    public function destroy(string $id)
    {
        // Vérifier si la spécialité est utilisée par un médecin
        $service = Service::findOrFail($id);

        $service->delete();

        return redirect()->route('service.index')
            ->with('success', 'Spécialité supprimée avec succès');
    }
}
