@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])

@php
    $role = Auth::user()->role;
    $has_kiosk = false;
@endphp

<div class="container-fluid">
    @if (($role == "student" or $role == "vendor") and $has_kiosk == false)
    <div class="row">
        <!-- if user is participant and not yet applied for kiosk, render this-->
        <div class="card card-background col m-4">
            <div class="full-background" style="background-image: url('https://images.unsplash.com/photo-1541451378359-acdede43fdf4?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=934&amp;q=80')"></div>
            <div class="card-body">
                <p class="card-title h5 d-block text-white">You have not applied for KIOSK Access</p>
                <p class="card-description mb-4">It appears that you haven't yet applied for KIOSK access. To streamline your experience and take advantage of our KIOSK services, please click the button below to register KIOSK.</p>
                <button type="button" class="btn bg-gradient-primary mt-3">Apply KIOSK</button>    
            </div>
        </div>
    </div>
    @endif  

    <div class="row">
        {{-- manage kiosk --}}
        @if ((($role == "student" or $role == "vendor") and $has_kiosk) or $role == "admin")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4 fluid">
                <a class="d-block blur-shadow-image">
                    <img src="/img/carousel-1.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </a>
            </div>
            <div class="card-body">
                <button type="button" class="btn bg-gradient-primary mt-3">Manage KIOSK</button>
                <p class="card-description mb-4">Manage your KIOSK here.</p>
            </div>
        </div>        
        @endif

        {{-- manage report --}}
        @if ((($role == "student" or $role == "vendor") and $has_kiosk) or $role == "pp_admin")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4">
                <a class="d-block blur-shadow-image">
                    <img src="/img/carousel-2.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </a>
            </div>
            <div class="card-body">
                <button type="button" class="btn bg-gradient-primary mt-3">Manage Report</button>
                <p class="card-description mb-4">Manage your sales report here.</p>
            </div>
        </div>   
        @endif 

        {{-- manage complaint --}}
        @if ((($role == "student" or $role == "vendor") and $has_kiosk) or $role == "tech_team")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4">
                <a class="d-block blur-shadow-image">
                    <img src="/img/carousel-3.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </a>
            </div>
            <div class="card-body">
                <button type="button" class="btn bg-gradient-primary mt-3">Manage Complaint</button>
                <p class="card-description mb-4">Manage your complaint here.</p>
            </div>
        </div>
        @endif
        
        {{-- admin add new user --}}
        @if($role == "admin")
        <div class="card card-blog col m-4">
            <div class="position-relative mt-4">
                <a href="{{ route('admin-add-user') }}" class="d-block blur-shadow-image">
                    <img src="/img/carousel-3.jpg" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg">
                </a>
            </div>
            <div class="card-body">
                <button type="button" class="btn bg-gradient-primary mt-3">Add new user</button>
                <p class="card-description mb-4">Add new admin, PUPUK admin, FK bursary, FK technical team account</p>
            </div>
        </div>
        @endif
    </div>

</div> 
@include('layouts.footers.auth.footer')
@endsection

@push('js')
<script src="./assets/js/plugins/chartjs.min.js"></script>
<script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Mobile apps",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#fb6340",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
</script>
@endpush