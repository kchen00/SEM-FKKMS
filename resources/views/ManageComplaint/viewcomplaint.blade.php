@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'View Complaints', 'welcome_message' => 'View Complaints'])

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Complaints</h5>
                
                @if(count($complaints) > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Complaint Title</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaints as $complaint)
                                <tr>
                                    <td>{{ $complaint->complaint_title }}</td>
                                    <td>{{ $complaint->description }}</td>
                                    <td>{{ $complaint->complaint_status }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('complaint.destroy', $complaint->complaint_ID) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-primary">Close</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No complaints found.</p>
                @endif

            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
@endsection
