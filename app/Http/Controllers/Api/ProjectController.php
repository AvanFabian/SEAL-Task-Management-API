<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Tambahkan ini

class ProjectController extends Controller
{
    use AuthorizesRequests; // Tambahkan ini

    public function index()
    {
        $projects = Project::with('user')->get();
        return response()->json(['status' => 'success', 'data' => $projects]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        // Perbaikan untuk mengambil user_id
        $user = auth()->user();
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $project = Project::create([
            ...$validated,
            'user_id' => $user->id
        ]);

        return response()->json(['status' => 'success', 'data' => $project], 201);
    }

    public function show(Project $project)
    {
        $project->load(['user', 'tasks']);
        return response()->json(['status' => 'success', 'data' => $project]);
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string'
        ]);

        $project->update($validated);

        return response()->json(['status' => 'success', 'data' => $project]);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();
        return response()->json(['status' => 'success', 'message' => 'Project deleted']);
    }
}