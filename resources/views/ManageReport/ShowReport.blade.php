@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sale repot'])
<!-- display the sales chart -->
<!-- if role is participant, show chart, sale input form and comment left by pupuk admin -->
<!-- else, show the selected KIOSK sale report and a comment form -->
@php
    use Carbon\Carbon;
    $role = Auth::user()->role;
    $enable_action = false;
    if($role == "student" or $role == "vendor") {
        $enable_action = true; 
    }

    // hardcoded variable values, remove after controller is developed
    $pp_comments = "good job😁😁😁";
    $comment_date = "1/1/2023";

@endphp
<div class="container-fluid py-4">
    <div class="container">
        <!-- display the sales chart -->
        <div class="card m-2">
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                <div class="row">
                    {{-- infor for pupuk admin, hide when the user is participant --}}
                    @if($role == "pp_admin")
                    <div class="col-sm"><span>KIOSK ID:  {{  $kiosk_id  }}</span></div>
                    <div class="col-sm"><span>KIOSK Owner:  {{  $kiosk_owner  }}</span></div>
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
                <p>{{ $pp_comments  }}</p>
                <div class="author align-items-center">
                    <div class="name ps-3">
                        <div class="stats">
                            <small>Posted on {{  $comment_date  }}</small>
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
                        @php
                            $month_name = [
                                            'January', 'February', 'March', 'April', 'May', 'June', 'July',
                                            'August', 'September', 'October', 'November', 'December'
                                        ];
                        @endphp

                        {{-- for loop to create rows dynamically --}}
                        @foreach ($sales_data as $month => $sale)
                            <tr>                         
                                <!-- month column -->
                                <td class="align-middle text-left">
                                    <p class="text-xs font-weight-bold text-uppercase mb-0 ">{{ $month }}</p>
                                </td>
                    
                            @if($sale->isNotEmpty())
                                <!-- date added column -->
                                <td class="align-middle text-left">
                                    @php
                                        $formattedDate = Carbon::parse($sale[0]->created_at)->format('d/m/Y');
                                    @endphp
                                    <p class="text-xs font-weight-bold mb-0">{{ $formattedDate }}</p>
                                </td>

                                <!-- date edited column -->
                                <td class="align-middle text-left">
                                    @php
                                        $formattedDate = Carbon::parse($sale[0]->updated_at)->format('d/m/Y');
                                    @endphp
                                    <p class="text-xs font-weight-bold mb-0">{{  $formattedDate }}</p>
                                </td>
                                
                                <!-- action column -->
                                <td class="action_column align-middle text-left">
                                    <div class="action_buttons_div">
                                        <button class="btn btn-icon btn-3 btn-secondary" type="button" onclick="display_form(this)" @if(!$enable_action) disabled @endif>
                                            <span class="btn-inner--icon"><i class="fa fa-pencil"></i></span>
                                            <span class="btn-inner--text">Edit</span>
                                        </button>
                                    </div>
                                    <div class="sale_form_div form-group" style="display: none;">
                                        <form action="{{ route('update-sale-report') }}" method="POST">
                                            @csrf
                                            <input type="text" name="report_ID" hidden value="{{ $sale[0]->report_ID }}">
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="sale_input" placeholder="RM0.00" value="{{  number_format($sale[0]->sales,2) }}">
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="submit" class="form-control btn btn-icon btn-3 btn-primary" value="Submit">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>                                    
                                    </div>
                                </td>

                                <!-- sales column -->
                                <td class="align-middle">
                                    <p class="text-xs font-weight-bold mb-0">RM  {{  number_format($sale[0]->sales,2) }}</p>
                                </td>
                            @else
                                <!-- date added column -->
                                <td class="align-middle text-left">
                                    <p class="text-xs font-weight-bold mb-0"></p>
                                </td>

                                <!-- date edited column -->
                                <td class="align-middle text-left">
                                    <p class="text-xs font-weight-bold mb-0"></p>
                                </td>
                                
                                <!-- action column -->
                                <td class="action_column align-middle text-left">
                                    <div class="action_buttons_div">
                                        <button class="btn btn-icon btn-3 btn-primary add_button" type="button" onclick="display_form(this)" @if(!$enable_action) disabled @endif>
                                            <span class="btn-inner--icon"><i class="ni ni-fat-add"></i></span>
                                            <span class="btn-inner--text">Add</span>
                                        </button>
                                    </div>
                                    <div class="sale_form_div form-group" style="display: none;">
                                        <form action="{{ route('submit-sale-report') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="sale_input" placeholder="RM0.00">
                                                </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="submit" class="form-control btn btn-icon btn-3 btn-primary" value="Submit">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>                                    
                                    </div>
                                </td>

                                <!-- sales column -->
                                <td class="align-middle">
                                    <p class="text-xs font-weight-bold mb-0">There is no sale data in record, please add one.</p>
                                </td>
                            @endif
                        </tr>
                        @endforeach
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
    let months = [];
    let sales = []
    sales_data_chart = {!! json_encode($sales_data) !!};

    for (const key in sales_data_chart) {
        if (Object.prototype.hasOwnProperty.call(sales_data_chart, key)) {
            months.push(key);   
            sales.push(sales_data_chart[key][0]["sales"]);
        }
    }

    var ctx1 = document.getElementById("bar-chart").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');
    new Chart(ctx1, {
        type: "bar",
        data: {
            labels: months,
            datasets: [{
                label: "Sales  ",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#fb6340",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: sales,
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
<script>
    function display_form(button) {
        var action_column= button.closest('.action_column');
        var action_buttons_div = action_column.querySelector(".action_buttons_div")
        var form_div = action_column.querySelector('.sale_form_div');
        
        action_buttons_div.style.display = 'none'; // Hide the Add button
        form_div.style.display = 'block'; // Show the form 
    }
</script>
@endpush