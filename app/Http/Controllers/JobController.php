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

  
   

}
