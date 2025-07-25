<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lawyer;

class LawyerController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'tipoDocumento' => 'required|string|max:50',
            'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento',
            'correo' => 'required|email|unique:lawyers,correo',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:255',
        ]);

        Lawyer::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'tipo_documento' => $validated['tipoDocumento'],
            'numero_documento' => $validated['numeroDocumento'],
            'correo' => $validated['correo'],
            'telefono' => $validated['telefono'] ?? null,
            'especialidad' => $validated['especialidad'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Abogado creado correctamente.');
    }
    public function destroy(Lawyer $lawyer)
        {
    $lawyer->delete();
    return redirect()->back()->with('success', 'Abogado eliminado exitosamente.');
    }

    public function edit(Lawyer $lawyer)
{
    // Si usas modal, puedes omitir esta vista, pero es estándar en Laravel
    return view('lawyers.edit', compact('lawyer'));
}

public function update(Request $request, Lawyer $lawyer)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'tipoDocumento' => 'required|string|max:50',
        'numeroDocumento' => 'required|string|max:50|unique:lawyers,numero_documento,' . $lawyer->id,
        'correo' => 'required|email|unique:lawyers,correo,' . $lawyer->id,
        'telefono' => 'nullable|string|max:20',
        'especialidad' => 'nullable|string|max:255',
    ]);

    $lawyer->update([
        'nombre' => $validated['nombre'],
        'apellido' => $validated['apellido'],
        'tipo_documento' => $validated['tipoDocumento'],
        'numero_documento' => $validated['numeroDocumento'],
        'correo' => $validated['correo'],
        'telefono' => $validated['telefono'] ?? null,
        'especialidad' => $validated['especialidad'] ?? null,
    ]);

    return redirect()->back()->with('success', 'Abogado actualizado correctamente.');
}


}
