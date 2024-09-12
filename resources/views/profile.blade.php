@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">
                    <h4>User Profile</h4>
                </div>
                <div class="card-body">
                    <h5><strong>Name:</strong> {{ $user->name }}</h5>
                    <h5><strong>Email:</strong> {{ $user->email }}</h5>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h4>Job Applications</h4>
                </div>
                <div class="card-body">
                   
                    @if(!$applications)
                        <p>No applications submitted yet.</p>
                    @else
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Resume</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                    <tr>
                                        <td>{{ $application->name }}</td>
                                        <td>{{ $application->email }}</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $application->resume) }}" target="_blank" class="btn btn-sm btn-primary">
                                                View Resume
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
