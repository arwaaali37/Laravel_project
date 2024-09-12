<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create($jobId)
    {
        $job = JobList::findOrFail($jobId);
        return view('job_applications.create', compact('job'));
    }
    public function store(Request $request, $jobId)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter' => 'nullable|string',
        ]);

        $job = JobList::findOrFail($jobId);

        $application = new JobApplication();
        $application->job_id = $job->id;
        $application->user_id = Auth::id();

        $application->resume = '';

        if ($request->hasFile('resume')) {
            $path = $request->file('resume')->store('resumes', 'public');
            $application->resume = $path;
           
        }
       
        $application->cover_letter = $request->input('cover_letter');
        $application->status = 'pending';
        $application->save();

        return redirect()->route('jobs.show', $job->id)->with('success', 'Application submitted successfully.');
    }

    public function show($id)
    {
        $application = JobApplication::findOrFail($id);
        return view('job_applications.show', compact('application'));
    }

    
    public function index()
    {
        
        $employer = auth()->user();
    
        
        $applications = JobApplication::whereHas('job', function($query) use ($employer) {
            $query->where('user_id', $employer->id); 
        })->get();
    
        return view('applications.index', compact('applications'));
    }
    
    public function approve($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->status = 'approved';
        $application->save();
    
        return redirect()->back()->with('success', 'Application approved successfully.');
    }
    
    public function reject($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->status = 'rejected';
        $application->save();
    
        return redirect()->back()->with('success', 'Application rejected successfully.');
    }


    public function destroy(JobApplication $application)
    {
        $application->delete();
        
        return redirect()->back()->with('success', 'Application deleted successfully.');
    }


    public function appplicationsOnProfile()
    {
        $user = Auth::user();
        
        $applications = JobApplication::where('user_id',$user->id)->get();
        // dd($user->id);
        // dd($applications[0]->name);
        return view('profile' , ['applications'=> $applications, 'user'=>$user ]);
    }
    


    

}
