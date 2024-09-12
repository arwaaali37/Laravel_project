<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'category', 'location', 'technologies', 'work_type', 'salary_range', 'deadline', 'company_logo', 'is_approved'
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];
    public function user()
    {
    return $this->belongsTo(User::class);
    }
    public function applications()
{
    return $this->hasMany(JobApplication::class, 'job_id');
}
}