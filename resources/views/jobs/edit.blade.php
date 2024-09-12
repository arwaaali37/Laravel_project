@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Job Listing</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Job Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $job->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Job Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ old('description', $job->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" name="category" id="category" class="form-control" value="{{ old('category', $job->category) }}" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $job->location) }}" required>
        </div>

        <div class="form-group">
            <label for="technologies">Technologies</label>
            <input type="text" name="technologies" id="technologies" class="form-control" value="{{ old('technologies', $job->technologies) }}" required>
        </div>

        <div class="form-group">
            <label for="work_type">Work Type</label>
            <select name="work_type" id="work_type" class="form-control" required>
                <option value="remote" {{ old('work_type', $job->work_type) == 'remote' ? 'selected' : '' }}>Remote</option>
                <option value="onsite" {{ old('work_type', $job->work_type) == 'onsite' ? 'selected' : '' }}>Onsite</option>
                <option value="hybrid" {{ old('work_type', $job->work_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
        </div>

        <div class="form-group">
            <label for="salary_range">Salary Range</label>
            <input type="text" name="salary_range" id="salary_range" class="form-control" value="{{ old('salary_range', $job->salary_range) }}">
        </div>

        <div class="form-group">
            <label for="deadline">Application Deadline</label>
            <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $job->deadline) }}">
        </div>

        <div class="form-group">
            <label for="company_logo">Company Logo (Optional)</label>
            <input type="file" name="company_logo" id="company_logo" class="form-control-file">
            @if($job->company_logo)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $job->company_logo) }}" alt="Company Logo" class="img-thumbnail" width="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Job</button>
    </form>
</div>
@endsection
