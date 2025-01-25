<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    use AuthorizesRequests; 

    public function index()
    {
        $projects = Project::with('user')->get();
        return response()->json(['status' => 'success', 'data' => $projects]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string'
            ], [
                'name.required' => 'Nama project harus diisi',
                'name.max' => 'Nama project tidak boleh lebih dari 255 karakter'
            ]);
            
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token tidak valid atau kadaluarsa'
                ], 401);
            }
    
            $project = Project::create([
                ...$validated,
                'user_id' => $user->id
            ]);
    
            return response()->json([
                'status' => 'success',
                'data' => $project,
                'message' => 'Project berhasil dibuat'
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat project: ' . $e->getMessage()
            ], 400);
        }
    }

    public function show(Project $project)
    {
        $project->load(['user', 'tasks']);
        return response()->json(['status' => 'success', 'data' => $project]);
    }

    public function update(Request $request, Project $project)
    {
        try {
            $this->authorize('update', $project);
    
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string'
            ], [
                'name.max' => 'Nama project tidak boleh lebih dari 255 karakter'
            ]);
    
            $project->update($validated);
    
            return response()->json([
                'status' => 'success',
                'data' => $project,
                'message' => 'Project berhasil diupdate'
            ]);
    
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk mengubah project ini'
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengupdate project: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();
        return response()->json(['status' => 'success', 'message' => 'Project deleted']);
    }
}