@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Complaint form', 'welcome_message' => 'Complaint form'])
<!-- if the user has not yet applied for KIOSK, render this-->
<div class="container-fluid py-4 row ">
    <div class="card col">
        <div class="card-body text-center" style="font-family: Arial, Helvetica, sans-serif;">
            <h4 class="card-title " style="margin-bottom: 30px;">Customer Complaint Form </h4>
            <form id="fs-frm" name="complaint-form" class="row g-3" accept-charset="utf-8" action="{{ route('complaint-form.store') }}" method="post">
                @csrf
                <input type="hidden" name="parti_ID" class="form-control" value="{{ $user->user_ID }}">
                <!-- complaintform.blade.php -->
                <div class="form-group col-md-5" style="text-align: start">
                    <label for="example-fullname-input" class="form-control-label form-label">Full name</label>
                    <input type="FullName" name="name" id="full-name" class="form-control" placeholder="First and Last" required="" value="{{ $user->username ?? '' }}">
                </div>
                <div class="form-group col-md-4" style="text-align: start;">
                    <label for="example-email-input" class="form-control-label">Email</label>
                    <input type="Email" name="_replyto" id="email-address" class="form-control" placeholder="email@domain.tld" required="" value="{{ $user->email ?? '' }}">
                </div>
                <div class="form-group col-md-3 " style="text-align: start;">
                    <label for="example-tel-input" class="form-control-label">Phone</label>
                    <input type="phoneNum" name="phoneNum" id="telephone" class="form-control" placeholder="(555) 555-5555" value="{{ $user->phone_num ?? '' }}">
                </div>
                <div class="form-group col-md-12" style="text-align:start">
                    <label for="example-text-input" class="form-control-label ">Complaint title</label>
                    <input class="form-control" type="text" name="complaintTitle" id="example-text-input" required>
                </div>
                <div class="form-group" style="text-align: start;">
                    <label for="exampleFormControlTextarea1">Complaint details</label>
                    <textarea class="form-control" name="complaintDetails" id="exampleFormControlTextarea1" rows="3" required></textarea>
                </div>
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary col-md-2">Submit</button>
                </div>

            </form>
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