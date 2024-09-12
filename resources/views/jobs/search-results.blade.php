@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results</h1>

    @if($jobs->count())
        <ul class="list-group">
            @foreach($jobs as $job)
                <li class="list-group-item">
                    <a href="{{ route('jobs.show', $job->id) }}">{{ $job->title }}</a>
                    <p>{{ $job->description }}</p>
                    <p><strong>Location:</strong> {{ $job->location }}</p>
                    <p><strong>Category:</strong> {{ $job->category }}</p>
                    <p><strong>Salary:</strong> {{ $job->salary_range }}</p>
                    <p><strong>Date Posted:</strong> {{ $job->created_at->format('Y-m-d') }}</p>
                </li>
            @endforeach
        </ul>

       
        {{ $jobs->links() }}
    @else
        <p>No jobs found matching your search criteria.</p>
    @endif

    <a href="{{ route('jobs.index') }}" class="btn btn-secondary mt-3">Back to Jobs</a>
</div>
@endsection
