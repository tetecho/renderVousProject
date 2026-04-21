<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::where('role', 'patient')->get();
        return view('patient.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string|max:20',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role']     = 'patient';
        User::create($validated);

        return redirect()->route('patient.index')->with('success', true);
    }

    public function show(string $id)
    {
        $patient = User::findOrFail($id);
        return view('patient.show', compact('patient'));
    }

    public function edit(string $id)
    {
        $patient = User::findOrFail($id);
        return view('patient.edit', compact('patient'));
    }

    public function update(Request $request, string $id)
    {
        $patient = User::findOrFail($id);

        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);

        // only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $patient->update($validated);

        return redirect()->route('patient.index')->with('success', true);
    }

    public function destroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('patient.index')->with('success', true);
    }
}
