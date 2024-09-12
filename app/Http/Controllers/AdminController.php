<?php
namespace App\Http\Controllers;

use App\Models\JobList;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function approveJob($id)
    {
        $job = JobList::findOrFail($id);

       
        if (auth()->user()->can('approve', $job)) {
            $job->is_approved = true;
            $job->save();

            return redirect()->back()->with('success', 'Job approved successfully.');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    public function rejectJob($id)
    {
        $job = JobList::findOrFail($id);

        
        if (auth()->user()->can('reject', $job)) {
            $job->delete(); 

            return redirect()->back()->with('success', 'Job rejected successfully.');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }
}
