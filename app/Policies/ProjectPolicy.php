<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
class ProjectPolicy
{
    // fungsi update dan delete akan menerima dua parameter, yaitu user dan project.
    // parameter tersebut digunakan untuk memeriksa apakah user yang sedang mencoba mengakses project adalah user yang memiliki project tersebut.
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }
}