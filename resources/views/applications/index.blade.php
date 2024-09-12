@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Applications</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Job Title</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $application)
                <tr>
                    <td>{{ $application->name }}</td>
                    <td>{{ $application->email }}</td>
                    <td>{{ $application->phone }}</td>
                    <td>{{ $application->job->title }}</td>
                    <td>{{ ucfirst($application->status) }}</td>
                    <td>
                        @if($application->status === 'pending')
                            <form action="{{ route('applications.approve', $application->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('applications.reject', $application->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
