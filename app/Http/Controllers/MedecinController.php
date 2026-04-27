<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MedecinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medecins = User::where('role', 'medecin')->paginate(5);
        return view('medecin.index', compact('medecins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medecin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string|max:20',
        ]);

        // Fix typo + hash password correctly
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'medecin';

        User::create($validated);

        return redirect()->route('medecin.index')->with('success', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medecin = User::where('role', 'medecin')->findOrFail($id);
        return view('medecin.show', compact('medecin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $medecin = User::where('role', 'medecin')->findOrFail($id);
        return view('medecin.modify', compact('medecin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medecin = User::where('role', 'medecin')->findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // FIX unique on update
            'password' => 'nullable|min:6', // FIX: not required
            'phone' => 'nullable|string|max:20',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $medecin->update($validated);

        return redirect()->route('medecin.index')->with('success', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medecin = User::where('role', 'medecin')->findOrFail($id);
        $medecin->delete();

        return redirect()->route('medecin.index')->with('success', true);
    }
}