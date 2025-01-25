<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'project_id',
        'user_id'
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];

    // fungsi ini digunakan untuk mendefinisikan relasi antara model Task dengan model Project
    // Relasi ini menunjukkan bahwa satu task dimiliki oleh satu project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    // fungsi ini digunakan untuk mendefinisikan relasi antara model Task dengan model User
    // Relasi ini menunjukkan bahwa satu task dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}