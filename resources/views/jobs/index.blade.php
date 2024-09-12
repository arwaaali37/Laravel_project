@extends('layouts.app')

@section('content')
<div class="container">

@if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('success') }}
        </div>
    @endif



    <h1 class="mb-4">Job Listings</h1>
     
    @if(auth()->user()->role === 'candidate')
    <form method="POST" action="{{ route('jobs.search') }}">
      @csrf
    <div class="form-group">
        <input type="text" name="title" class="form-control" placeholder="Search by job title" value="{{ request('title') }}">
    </div>
    <div class="form-group">
        <input type="text" name="location" class="form-control" placeholder="Location" value="{{ request('location') }}">
    </div>
    <div class="form-group">
        <input type="text" name="category" class="form-control" placeholder="Category" value="{{ request('category') }}">
    </div>
    <div class="form-group">
        <input type="text" name="salary_range" class="form-control" placeholder="Salary Range" value="{{ request('salary_range') }}">
    </div>
    <div class="form-group">
        <input type="date" name="date_posted" class="form-control" value="{{ request('date_posted') }}">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Search</button>
</form>

@endif
    <br>

    
    @if(auth()->user()->role === 'employer')
        <div class="mb-4">
            <a href="{{ route('jobs.create') }}" class="btn btn-primary">Post a New Job</a>
        </div>
    @endif

   
    @foreach($jobs as $job)
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $job->title }}</h5>
                <p>{{ $job->description }}</p>
                <p><strong>Location:</strong> {{ $job->location }}</p>
                <p><strong>Technologies:</strong> {{ $job->technologies }}</p>
                <p><strong>Salary:</strong> {{ $job->salary_range }}</p>


             
            @if(auth()->user()->role === 'admin')
            @if(auth()->user()->can('approve', $job))
              <a href="{{ route('admin.approveJob', $job->id) }}" class="btn btn-success">Approve Job</a>
            @endif

            @if(auth()->user()->can('reject', $job))
                <a href="{{ route('admin.rejectJob', $job->id) }}" class="btn btn-danger">Reject Job</a>
            @endif
            @endif

           
             
              <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-info">View</a>
              
               
               @if(auth()->user()->role === 'employer' && auth()->user()->id === $job->user_id)
                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-secondary">Edit</a>
                  <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline-block">
                      @csrf
                      @method('DELETE')
                    <button type="submit" style="display:inline-block" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                  </form>
              @endif

            </div>
        </div>

       
        @if(auth()->check() && auth()->user()->role === 'employer')
        @if($job->applications && $job->applications->count() > 0)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Applications for {{ $job->title }}</h5>
                    @foreach ($job->applications as $application)
                        <div class="application mb-3">
                            <p><strong>Applicant:</strong> {{ $application->user->name }}</p>
                            <p><strong>Resume:</strong> <a href="{{ asset('storage/' . $application->resume) }}" target="_blank">View Resume</a></p>
                            <p><strong>Status:</strong> {{ ucfirst($application->status) }}</p>

                            @if ($application->status === 'pending')
                                <form action="{{ route('applications.approve', $application->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>

                                <form action="{{ route('applications.reject', $application->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Reject</button>
                                </form>
                            @else
                                <p>This application has been {{ $application->status }}.</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p>No applications yet for this job.</p>
        @endif
        @endif 
    @endforeach

   
    <div class="d-flex justify-content-center">
        {{ $jobs->links() }}
    </div>
</div>
@endsection