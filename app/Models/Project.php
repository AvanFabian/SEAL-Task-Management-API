<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    // fungsi ini digunakan untuk mendefinisikan relasi antara model Project dengan model User.
    // Relasi ini menunjukkan bahwa satu project dimiliki oleh satu user.

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // fungsi ini digunakan untuk mendefinisikan relasi antara model Project dengan model Task.
    // Relasi ini menunjukkan bahwa satu project memiliki banyak task.

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}