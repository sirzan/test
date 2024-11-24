<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Lista todos los proyectos con los usuarios asociados.
     */
    public function index()
    {
        $projects = Project::with(['users'])->latest()->get();
        return response()->json($projects);
    }


    /**
     * Crea un nuevo proyecto y asocia usuarios al mismo.
     */
    public function store(Request $request)
    {
        // Valida los datos del proyecto
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'users' => 'required|array', // Debe ser un array de IDs de usuarios
            'users.*' => 'exists:users,id', // Cada usuario debe existir en la base de datos
        ]);


        $project = Project::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Asocia los usuarios al proyecto
        $project->users()->sync($validated['users']);

        return response()->json($project->load('users'), 201);
    }

    /**
     * Muestra un proyecto específico con los usuarios asociados.
     */
    public function show($id)
    {
        $project = Project::with('users')->find($id);

        if (!$project) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        return response()->json($project);
    }

    /**
     * Actualiza un proyecto específico y sus usuarios asociados.
     */
    public function update(Request $request, $id)
    {
        // Encuentra el proyecto a actualizar
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        // Valida los datos enviados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'users' => 'nullable|array', // Puede ser null si no se quieren actualizar los usuarios
            'users.*' => 'exists:users,id',
        ]);

        $project->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Si se envían usuarios, sincronízalos
        if (isset($validated['users'])) {
            $project->users()->sync($validated['users']);
        }

        return response()->json($project->load('users'));
    }

    /**
     * Elimina un proyecto específico.
     */
    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        $project->delete();

        return response()->json(['message' => 'Proyecto eliminado correctamente']);
    }
}
