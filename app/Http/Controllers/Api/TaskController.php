<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $tasks = $query->with(['user', 'project'])->get();
        return response()->json(['status' => 'success', 'data' => $tasks]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:todo,in_progress,completed',
                'due_date' => 'nullable|date',
                'project_id' => 'required|exists:projects,id',
                'user_id' => 'required|exists:users,id'
            ], [
                'title.required' => 'Judul task harus diisi',
                'title.max' => 'Judul task tidak boleh lebih dari 255 karakter',
                'status.required' => 'Status task harus diisi',
                'status.in' => 'Status task harus todo, in_progress, atau completed',
                'due_date.date' => 'Format tanggal tidak valid',
                'project_id.required' => 'Project ID harus diisi',
                'project_id.exists' => 'Project tidak ditemukan',
                'user_id.required' => 'User ID harus diisi',
                'user_id.exists' => 'User tidak ditemukan'
            ]);
    
            $task = Task::create($validated);
    
            return response()->json([
                'status' => 'success',
                'data' => $task,
                'message' => 'Task berhasil dibuat'
            ], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat task: ' . $e->getMessage()
            ], 400);
        }
    }

    public function show(Task $task)
    {
        $task->load(['user', 'project']);
        return response()->json(['status' => 'success', 'data' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        try {
            $this->authorize('update', $task);
    
            $validated = $request->validate([
                'title' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'status' => 'sometimes|in:todo,in_progress,completed',
                'due_date' => 'nullable|date',
                'user_id' => 'sometimes|exists:users,id'
            ], [
                'title.max' => 'Judul task tidak boleh lebih dari 255 karakter',
                'status.in' => 'Status task harus todo, in_progress, atau completed',
                'due_date.date' => 'Format tanggal tidak valid',
                'user_id.exists' => 'User tidak ditemukan'
            ]);
    
            $task->update($validated);
    
            return response()->json([
                'status' => 'success',
                'data' => $task,
                'message' => 'Task berhasil diupdate'
            ]);
    
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda tidak memiliki akses untuk mengubah task ini'
            ], 403);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengupdate task: ' . $e->getMessage()
            ], 400);
        }
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(['status' => 'success', 'message' => 'Task deleted']);
    }
}