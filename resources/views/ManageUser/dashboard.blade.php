@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])

@php
    $role = Auth::user()->role;
@endphp

<div class="container-fluid">
    @if (($role == "student" or $role == "vendor") && $application_status != "accepted")
    <div class="row">
        <!-- if user is participant and not yet applied for kiosk, render this-->
        <div class="card card-background col m-4">
            <div class="full-background" style="background-image: url('https://images.unsplash.com/photo-1541451378359-acdede43fdf4?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=934&amp;q=80')"></div>
            <div class="card-body text-center">
                @if(!$has_application)
                    <p class="card-title h5 d-block text-white">You have not applied for KIOSK Access</p>
                    <p class="card-description mb-4">It appears that you haven't yet applied for KIOSK access. To streamline your experience and take advantage of our KIOSK services, please click the button below to register KIOSK.</p>
                    <a class="btn bg-gradient-primary mt-3" href="{{ route('application.manage') }}">Apply KIOSK</a> 
                @elseif($application_status == "in_progress")
                    <p class="card-title h5 d-block text-white">Your application has been submitted but is not yet approved.</p>
                    <p class="card-description mb-4 text-white">Please wait patiently or contact admin for further details.</p>
                @elseif($application_status == "rejected")
                    <p class="card-title h5 d-block text-white">Your application has been rejected.</p>
                    <p class="card-description mb-4 text-white">Contact admin for further details.</p>
                    <p class="card-description mb-4 text-white">Or submit a new application</p>
                    <a class="btn bg-gradient-primary mt-3" href="{{ route('application.manage') }}">Submit New Application</a> 
                @endif
            </div>
        </div>
    </div>
    @endif  

    <div class="row">
        {{-- manage kiosk --}}
        @if ((($role == "student" || $role == "vendor") and $application_status == "accepted") or $role == "admin")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4 fluid">
                <div class="d-block blur-shadow-image">
                    <img src="/img/carousel-1.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </div>
            </div>
            <div class="card-body">
                @if($role == "admin")
                    <a href="{{ route('application.adminManage') }}" class="btn btn-primary mt-3">Manage KIOSK</a>
                @else
                    <a href="{{ route('application.manage') }}" class="btn btn-primary mt-3">Manage KIOSK</a>
                @endif
                <p class="card-description mb-4">Manage your KIOSK here.</p>
            </div>
        </div>        
        @endif

        {{-- manage report --}}
        @if ((($role == "student" || $role == "vendor") and $application_status == "accepted") or $role == "pp_admin")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4">
                <div class="d-block blur-shadow-image">
                    <img src="/img/carousel-2.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </div>
            </div>
            <div class="card-body">
                @if($role != "pp_admin")
                    <a href="{{ route('show-report') }}" class="btn btn-primary mt-3">Manage Sales</a>
                @else
                    <a href="{{ route('show-kiosk') }}" class="btn btn-primary mt-3">Manage Sales</a>
                @endif
                <p class="card-description mb-4">Manage your sales report here.</p>
            </div>
        </div>   
        @endif 

        {{-- manage complaint --}}
        @if ((($role == "student" || $role == "vendor") and $application_status == "accepted") or $role == "tech_team")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4">
                <div class="d-block blur-shadow-image">
                    <img src="/img/carousel-3.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('complaint-menu') }}" class="btn btn-primary mt-3">Manage Complaint</a>
                <p class="card-description mb-4">Manage your complaint here.</p>
            </div>
        </div>
        @endif
        
        {{-- admin add new user --}}
        @if($role == "admin")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4">
                <div class="d-block blur-shadow-image">
                    <img src="/img/carousel-3.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('admin-add-user') }}" class="btn btn-primary mt-3">Add New User</a>
                <p class="card-description mb-4">Add new admin, PUPUK admin, FK bursary, FK technical team account and participant account</p>
            </div>
        </div>
        @endif

        @if($role == "bursary")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4">
                <div class="d-block blur-shadow-image">
                    <img src="/img/carousel-3.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('payment.bursaryManage') }}" class="btn btn-primary mt-3">Manage Payments</a>
                <p class="card-description mb-4">Manage payments of KIOSK participants</p>
            </div>
        </div>
        @endif
    </div>

</div> 
@include('layouts.footers.auth.footer')
@endsection