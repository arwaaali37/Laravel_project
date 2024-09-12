<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

  
    protected $table = 'job_applications';

   
    protected $fillable = [
        'user_id', 
        'job_id', 
        'name', 
        'phone', 
        'email', 
        'resume',
        'status' 
    ];

    
    public function job()
    {
        return $this->belongsTo(JobList::class, 'job_id');
    }

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
