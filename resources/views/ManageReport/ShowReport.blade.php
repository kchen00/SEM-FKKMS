@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sale repot'])
<!-- display the sales chart -->
<!-- if role is participant, show chart, sale input form and comment left by pupuk admin -->
<!-- else, show the selected KIOSK sale report and a comment form -->
@php
    $role = Auth::user()->role;
    $enable_action = false;
    if($role == "student" or $role == "vendor") {
        $enable_action = true; 
    }
@endphp
<div class="container-fluid py-4">
    <div class="container">
        <!-- display the sales chart -->
        <div class="card m-2">
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                <div class="row">
                    {{-- infor for pupuk admin, hide when the user is participant --}}
                    @if($role == "pp_admin")
                    <div class="col-sm"><span>KIOSK ID:</span></div>
                    <div class="col-sm"><span>KIOSK Owner:</span></div>
                    @endif
                    {{-- sort sales dropdown options --}}
                    <div class="col-sm">
                        <span>
                            <div class="d-flex justify-content-end mb-3">
                                <div class="dropdown">
                                    <button class="btn bg-gradient-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Sort by
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Monthly</a></li>
                                        <li><a class="dropdown-item" href="#">Yearly</a></li>
                                    </ul>
                                </div>
                            </div> 
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="chart">
                    <canvas id="bar-chart" class="chart-canvas" height="500px"></canvas>
                </div>
            </div>
        </div>


        <div class="card m-2">
            <!-- comment left by the pupuk admin -->
            @if ($role == "student" or $role == "vendor")
            {{-- if user is participant, show the comment --}}
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1 text-primary font-weight-bold">
                <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Comments by PUPUK admin</span>
            </div>
            <div class="card-body pt-2">
                <p>Good job! 😁😁😁</p>
                <div class="author align-items-center">
                    <div class="name ps-3">
                        <span>Mathew Glock</span>
                        <div class="stats">
                            <small>Posted on 28 February</small>
                        </div>
                    </div>
                </div>
            </div>

            @elseif($role == "pp_admin")
            {{-- if user is pupuk admin show a form to submit comment --}}
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1 text-primary font-weight-bold">
                <span class="text-gradient text-primary text-uppercase text-xs font-weight-bold my-2">Sale Performance</span>
            </div>
            <div class="card-body pt-2">
                <form>
                    <div class="form-group">
                        <label for="pp_comment">PUPUK admin comment</label>
                        <textarea class="form-control" id="pp_comment" rows="3" placeholder="Leave your comment here"></textarea>
                    </div>
                    <input class="btn btn-icon btn-3 btn-primary" type="submit">
                </form>
            </div>
            @endif
        </div>

        <!-- table for sales entry -->
        <div class="card m-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Month</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Added</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Edited</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- month column -->
                            <td class="align-middle text-left">
                                <p class="text-xs font-weight-bold text-uppercase mb-0 ">January</p>
                            </td>

                            <!-- date added column -->
                            <td class="align-middle text-left">
                                <p class="text-xs font-weight-bold mb-0">1/1/2023</p>
                            </td>

                            <!-- date edited column -->
                            <td class="align-middle text-left">
                                <p class="text-xs font-weight-bold mb-0">1/1/2023</p>
                            </td>
                            
                            <!-- action column -->
                            <td class="align-middle text-left">
                                <button class="btn btn-icon btn-3 btn-primary" type="button" @if(!$enable_action) disabled @endif>
                                    <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                    <span class="btn-inner--text">Add</span>
                                </button>
                                <button class="btn btn-icon btn-3 btn-secondary" type="button" @if(!$enable_action) disabled @endif>
                                    <span class="btn-inner--icon"><i class="fa fa-pencil"></i></span>
                                    <span class="btn-inner--text">Edit</span>
                                </button>
                            </td>

                            <!-- sales column -->
                            <td class="align-middle">
                                <p class="text-xs font-weight-bold mb-0">RM100.00</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @include('layouts.footers.auth.footer')
    @endsection

    @push('js')
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx1 = document.getElementById("bar-chart").getContext("2d");

        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
        new Chart(ctx1, {
            type: "bar",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales  ",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 50

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