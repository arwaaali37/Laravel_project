@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $job->title }}</h1>

    <div class="card mb-3">
        @if ($job->company_logo)
            <img src="{{ asset('storage/' . $job->company_logo) }}" class="card-img-top" style="width:25%" alt="Company Logo">
        @endif

        <div class="card-body">
            <p class="card-text"><strong>Description:</strong> {{ $job->description }}</p>
            <p class="card-text"><strong>Category:</strong> {{ $job->category }}</p>
            <p class="card-text"><strong>Location:</strong> {{ $job->location }}</p>
            <p class="card-text"><strong>Technologies:</strong> {{ $job->technologies }}</p>
            <p class="card-text"><strong>Work Type:</strong> {{ ucfirst($job->work_type) }}</p>
            <p class="card-text"><strong>Salary Range:</strong> {{ $job->salary_range }}</p>
            <p class="card-text"><strong>Deadline:</strong> {{ $job->deadline ? $job->deadline->format('Y-m-d') : 'N/A' }}</p>
            <p class="card-text"><strong>Status:</strong> {{ $job->is_approved ? 'Approved' : 'Pending Approval' }}</p>
            <a href="{{ route('jobs.index') }}" class="btn btn-secondary">Back to List</a>
            @can('update', $job)
                <a href="{{ route('jobs.edit', $job->id) }}" class="btn btn-primary">Edit</a>
            @endcan
            @can('delete', $job)
                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            @endcan
        </div>
    </div>

   
    @can('view-applications', $job)
        <h2 class="mt-4">Applications</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Applicant Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Resume</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($job->applications as $application)
                    <tr>
                        <td>{{ $application->user->name }}</td>
                        <td>{{ $application->phone }}</td>
                        <td>{{ $application->email }}</td>
                        <td><a href="{{ asset('storage/' . $application->resume) }}" target="_blank">View Resume</a></td>
                        <td>{{ ucfirst($application->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No applications received yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endcan

    
    @if(auth()->check())
        @if(auth()->user()->isCandidate())
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Apply for this Job</h5>
                    <form method="POST" action="{{ route('jobs.apply', $job->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                            @error('name')
                            
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone:</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                            @error('phone')
                            
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                            @error('email')
                            
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="form-group">
                            <label for="resume">Upload your resume:</label>
                            <input type="file" name="resume" id="resume" class="form-control" required>
                            @error('resume')
                            
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Apply</button>
                    </form>
                </div>
            </div>
        @else
            <p>Only candidates can apply for this job. Please <a href="{{ route('login') }}">log in</a> as a candidate to apply.</p>
        @endif
    @else
        <p>Please <a href="{{ route('login') }}">log in</a> to apply for this job.</p>
    @endif

</div>
@endsection

