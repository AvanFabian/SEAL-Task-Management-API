<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // fungsi ini digunakan untuk mendefinisikan relasi antara model User dengan model Project
    // Relasi ini menunjukkan bahwa satu user memiliki banyak project
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    // fungsi ini digunakan untuk mendefinisikan relasi antara model User dengan model Task
    // Relasi ini menunjukkan bahwa satu user memiliki banyak task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
