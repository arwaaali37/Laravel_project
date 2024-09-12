<?php

namespace App\Http\Controllers;

use App\Models\JobList;
use Illuminate\Http\Request;
use App\Models\JobApplication; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

 
    public function index()
    {
        $user = Auth::user();
    
        if ($user->role === 'admin') {
            $jobs = JobList::with('applications') 
                           ->latest() 
                           ->paginate(3);
        } 
       
        elseif ($user->role === 'employer') {
            $jobs = JobList::with('applications') 
                           ->where('user_id', $user->id)
                           ->where('is_approved', true) 
                           ->latest()
                           ->paginate(3); 
        } 
       
        elseif ($user->role === 'candidate') {
            $jobs = JobList::where('is_approved', true) 
                           ->whereHas('user', function($query) {
                               $query->where('role', 'employer'); 
                           })
                           ->latest() 
                           ->paginate(3);
        }
    
        return view('jobs.index', compact('jobs'));
    }

   
    public function create()
    {
        return view('jobs.create');
    }

   
    public function store(Request $request)
    {
        $this->authorize('create', JobList::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'technologies' => 'nullable|string',
            'technologies.*' => 'string',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'salary_range' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'company_logo' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['technologies'] = json_encode($validated['technologies']); 

        $job = JobList::create($validated);

      
        if ($request->hasFile('company_logo')) {
            $path = $request->file('company_logo')->store('company_logos', 'public');
            $job->company_logo = $path;
            $job->save();
        }

        return redirect()->route('jobs.index')->with('success', 'Job posted successfully.');
    }

   
    public function show($id)
    {
        $job = JobList::find($id);

        if (!$job) {
            abort(404, 'Job not found');
        }

        return view('jobs.show', compact('job'));
    }

  
    public function edit($id)
    {
        $job = JobList::findOrFail($id);
        $this->authorize('update', $job);

        return view('jobs.edit', compact('job'));
    }

    
    public function update(Request $request, $id)
    {
        $job = JobList::findOrFail($id);
        $this->authorize('update', $job);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'required|string',
            'technologies' => 'nullable|string',
            'technologies.*' => 'string',
            'work_type' => 'required|in:remote,onsite,hybrid',
            'salary_range' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'company_logo' => 'nullable|image|max:2048',
        ]);

        $validated['technologies'] = json_encode($validated['technologies']); 

        $job->update($validated);

       
        if ($request->hasFile('company_logo')) {
            if ($job->company_logo) {
                Storage::delete('public/' . $job->company_logo);
            }
            $path = $request->file('company_logo')->store('company_logos', 'public');
            $job->company_logo = $path;
            $job->save();
        }

        return redirect()->route('jobs.index')->with('success', 'Job updated successfully.');
    }

  
    public function destroy($id)
    {
        $job = JobList::findOrFail($id);

        
        $this->authorize('delete', $job);

        $job->delete();

        return redirect()->route('jobs.index')->with('success', 'Job deleted successfully');
    }

    
    public function approve($id)
    {
        $job = JobList::findOrFail($id);
        $job->is_approved = true;
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job approved successfully.');
    }

    public function reject($id)
    {
        $job = JobList::findOrFail($id);
        $job->is_approved = false;
        $job->save();

        return redirect()->route('jobs.index')->with('success', 'Job rejected successfully.');
    }

    

    public function search(Request $request)
    {
        
        $title = $request->input('title');
        $location = $request->input('location');
        $category = $request->input('category');
        $salaryRange = $request->input('salary_range');
        $datePosted = $request->input('date_posted');

        
        $query = JobList::query();

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($location) {
            $query->where('location', $location);
        }

        if ($category) {
            $query->where('category', $category);
        }

        if ($salaryRange) {
            $query->where('salary_range', $salaryRange);
        }

        if ($datePosted) {
            $query->whereDate('created_at', $datePosted);
        }

        
        $jobs = $query->paginate(10);
        return view('jobs.search-results', compact('jobs'));
    }



   
    public function apply(Request $request, $jobId)
    {
        
        
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('jobs.index')->with('error', 'You must be logged in to apply.');
        }


        // dd($user->role );
        if ($user->role != 'candidate') {
            return redirect()->route('jobs.show', $jobId)
                            ->with('error', 'You must be a candidate to apply for this job.');
        }

       

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'resume' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

       
        $job = JobList::find($jobId);

        // dd($job);
        if (!$job) {
            return redirect()->route('jobs.index')->with('error', 'Job not found.');
        }

       
        // $resumePath = $request->file('resume')->store('resumes');
        $resumePath  = '';
        if ($request->hasFile('resume')) {
            
            $path = $request->file('resume')->store('resumes', 'public');
            $resumePath = $path;
        }
       
        JobApplication::create([
            'user_id' => $user->id,
            'job_id' => $job->id,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'resume' => $resumePath,
            'status' => 'pending', 
        ]);

        return redirect()->route('jobs.index')->with('success', 'Application submitted successfully.');
    }

}
