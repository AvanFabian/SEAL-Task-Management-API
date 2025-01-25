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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:todo,in_progress,completed',
            'due_date' => 'nullable|date',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $task = Task::create($validated);

        return response()->json(['status' => 'success', 'data' => $task], 201);
    }

    public function show(Task $task)
    {
        $task->load(['user', 'project']);
        return response()->json(['status' => 'success', 'data' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:todo,in_progress,completed',
            'due_date' => 'nullable|date',
            'user_id' => 'sometimes|exists:users,id'
        ]);

        $task->update($validated);

        return response()->json(['status' => 'success', 'data' => $task]);
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->json(['status' => 'success', 'message' => 'Task deleted']);
    }
}