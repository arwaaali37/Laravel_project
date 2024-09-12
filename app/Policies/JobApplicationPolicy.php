<?php

namespace App\Policies;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobApplicationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any job applications.
     */
    public function viewAny(User $user): bool
    {
        
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view a specific job application.
     */
    public function view(User $user, JobApplication $jobApplication): bool
    {
       
        return $user->id === $jobApplication->user_id || $user->id === $jobApplication->job->user_id;
    }

    /**
     * Determine whether the user can create job applications.
     */
    public function create(User $user): bool
    {
       
        return $user->is_authenticated;
    }

    /**
     * Determine whether the user can update the job application.
     */
    public function update(User $user, JobApplication $application)
    {
       
        return $user->id === $application->job->employer_id;
    }

    /**
     * Determine whether the user can delete the job application.
     */
    public function delete(User $user, JobApplication $jobApplication): bool
    {
      
        return $user->id === $jobApplication->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can restore the job application.
     */
    public function restore(User $user, JobApplication $jobApplication): bool
    {
       
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can permanently delete the job application.
     */
    public function forceDelete(User $user, JobApplication $jobApplication): bool
    {
        
        return $user->role === 'admin';
    }
}
