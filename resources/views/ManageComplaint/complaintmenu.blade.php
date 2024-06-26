@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Manage complaint', 'welcome_message' => ''])
    <!-- if the user has not yet applied for KIOSK, render this -->


    <!-- if the user has KIOSK, render this -->
    <div class="container-fluid py-4 row justify-content-center">
        <div class="card col-md-4 m-4 text-center">
            <div class="card-body">
                <h5 class="card-title">New Complaint</h5>
                <img src="{{ asset('img/createcomplaint.png') }}" alt="Create Complaint" class="img-fluid mx-auto d-block"
                    style="width: 200px;">

                <!-- Update the "Create" button href to direct to the complaint-form route -->
                <div class="mt-3 d-flex justify-content-center">
                    <a href="{{ route('complaint-form') }}" class="btn btn-primary">Create</a>
                </div>
                {{-- this is the div for the hit button for create complain form  --}}
                <div class="mt-3">
                    <span class="hint-circle" data-toggle="tooltip" data-placement="right"
                        title="Click 'Create' to fill out the complaint form. Ensure all required fields are completed.">
                        ?
                    </span>
                </div>
            </div>
        </div>
        <div class="card col-md-4 m-4 text-center">
            <div class="card-body">
                <h5 class="card-title">View Complaint</h5>
                <img src="{{ asset('img/listcomplaint.png') }}" alt="List Complaint" class="img-fluid mx-auto d-block"
                    style="width: 200px;">
                <div class="mt-3 d-flex justify-content-center">
                    <a href="{{ route('complaint-shows') }}" class="btn btn-primary">View</a>
                </div>
                {{-- this is the div for the hit button for view complain form  --}}
                <div class="mt-3">
                    <span class="hint-circle" data-toggle="tooltip" data-placement="right"
                        title="Click 'View' to see list of complaints.">
                        ?
                    </span>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
@endsection

@push('js')
    {{-- this is the java script for hover the hint button --}}
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
