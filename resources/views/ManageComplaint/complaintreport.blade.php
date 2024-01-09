@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Complaint form', 'welcome_message' => 'Complaint form'])
    <!-- if the user has not yet applied for KIOSK, render this-->
    <div class="container-fluid py-4 row">
        <div class="card col">
            <div class="card-body text-center">
                <h5 class="card-title">Customer Information</h5>

                <div class="form-group">
                    <label for="example-text-input" class="form-control-label">Complaint details</label>
                    <!-- Display the complaint details fetched from the database -->
                    <input class="form-control" type="text" name="complaintDetails" id="example-text-input"
                           value="{{ $complaintDetails }}" required readonly>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Complaint solution</label>
                    <form action="{{ route('complaint.storeSolution') }}" method="POST">
                        @csrf
                        <textarea class="form-control" name="complaintSolution" id="exampleFormControlTextarea1"
                                  rows="3" required></textarea>
                        <!-- Add a hidden input field for the complaint ID if needed -->
                        <!-- <input type="hidden" name="complaint_ID" value="{{ $complaintID }}"> -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- if the user has KIOSK, render this -->

    @include('layouts.footers.auth.footer')
</div>
@endsection

@push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        // ... (your existing JavaScript code)
    </script>
@endpush
