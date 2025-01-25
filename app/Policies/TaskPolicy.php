<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    // fungsi update dan delete akan menerima dua parameter, yaitu user dan task.
    // parameter tersebut digunakan untuk memeriksa apakah user yang sedang mencoba mengakses task adalah user yang memiliki task tersebut / user yang memiliki project yang memiliki task tersebut.
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id || $user->id === $task->project->user_id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id || $user->id === $task->project->user_id;
    }
}