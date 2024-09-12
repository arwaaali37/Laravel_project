<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\JobList;
class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Job $job): bool
    {
        //
    }

    public function create(User $user)
{
    return $user->role === 'employer';
}

public function update(User $user, JobList $job)
{
   
    return $user->id === $job->user_id;
}

public function delete(User $user, JobList $job)
{
    return $user->id === $job->user_id;
}
    public function restore(User $user, Job $job): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        //
    }



    public function approve(User $user, JobList $job)
    {
        return $user->role === 'admin'; 
    }

    /**
     * Determine if the given job can be rejected by the user.
     */
    public function reject(User $user, JobList $job)
    {
        return $user->role === 'admin'; 
    }

}
