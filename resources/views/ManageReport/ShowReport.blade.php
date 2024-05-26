@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Sale repot'])
<!-- display the sales chart -->
<!-- if role is participant, show chart, sale input form and comment left by pupuk admin -->
<!-- else, show the selected KIOSK sale report and a comment form -->
@php
    use Carbon\Carbon;
    $role = Auth::user()->role;
@endphp
@push("js")
    <script src="/assets/js/plugins/chartjs.min.js"></script>
@endpush
<div class="container-fluid py-4">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Total sales:</p>
                                    <h5 class="font-weight-bolder">
                                        RM  {{  $total_sales }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Average sales:</p>
                                    <h5 class="font-weight-bolder">
                                        RM  {{  $average_sales }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                    <i class="fa fa-bar-chart opacity-10" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Sales Growth:</p>
                                    @if($growth > 0)
                                    <h5 class="font-weight-bolder">
                                        Better than last month
                                    </h5>
                                    @else
                                    <h5 class="font-weight-bolder">
                                        Worse than last month
                                    </h5>
                                    @endif
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                @if($growth > 0)
                                <div class="icon icon-shape bg-gradient-success shadow-warning text-center rounded-circle">
                                    <i class="fa fa-arrow-up opacity-10" aria-hidden="true"></i>
                                </div>
                                @else
                                <div class="icon icon-shape bg-gradient-danger shadow-warning text-center rounded-circle">
                                    <i class="fa fa-arrow-down opacity-10" aria-hidden="true"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold">Revenue:</p>
                                    <h5 class="font-weight-bolder">
                                        RM {{ number_format($revenue,2) }}
                                    </h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                @if($revenue > 0)
                                <div class="icon icon-shape bg-gradient-success shadow-warning text-center rounded-circle">
                                    <i class="fa fa-arrow-up opacity-10" aria-hidden="true"></i>
                                </div>
                                @else
                                <div class="icon icon-shape bg-gradient-danger shadow-warning text-center rounded-circle">
                                    <i class="fa fa-arrow-down opacity-10" aria-hidden="true"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- display the sales chart -->
        <div class="card m-2">
            <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1">
                <div class="container">
                    <div class="row">
                        @if($role == "pp_admin")
                            {{-- infor for pupuk admin, hide when the user is participant --}}
                            <div class="col">
                                <p class="text-start">KIOSK ID:  {{  $kiosk_id  }}</p>
                                <p class="text-start">KIOSK Owner:  {{  $kiosk_owner  }}</p>
                            </div>
                        @endif
                        <div class="col">
                            <div class="container">
                                @if($role == 'student'||$role == 'vendor')
                                    <form method="GET" action="{{ route('show-report') }}">
                                @else
                                    <form method="GET" action="{{ route('admin-show-report', ['participant_id' => $participant_id, 'kiosk_id' => $kiosk_id, 'kiosk_owner' => $kiosk_owner]) }}">
                                @endif
                                    <div class="row">
                                        <div class="col">
                                            <input type="number" name="view_year" class="form-control my-auto" id="viewYear" placeholder="Year" value="{{ $view_year }}">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary">Filter sales</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col position-relative">
                            <div class="dropdown position-absolute top-0 end-0">
                                <button class="btn bg-gradient-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                Sort by
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#" onclick="sort_by_month()">Monthly</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="sort_by_year()">Yearly</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-2">
                <div class="chart">
                    <canvas id="bar-chart" class="chart-canvas" height="500px"></canvas>
                </div>
            </div>
        </div>

        <!-- table for sales entry -->
        <div class="card">
            <div class="table-responsive">
                <table class="table align-items-center mb-0" id="salesTable">
                    <thead>
                        <tr>
                            @php
                                $colspan = 5;
                            @endphp
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Month</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Added</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Edited</th>
                            @if($role == "student"||$role == "vendor")
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                                @php
                                    $colspan = 6;
                                @endphp
                            @endif
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Cost</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sales</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Comments by PUPUK admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($sales_data->isEmpty())
                            <tr id="noSaleReport">
                                <td colspan="{{ $colspan }}">
                                    <div class="alert alert-danger text-light text-center" role="alert">
                                        @if($role=="admin"||$role=="pp_admin")
                                            <p class="text-center">There are no sales reports for this user.</p>
                                        @elseif($role=="student"||$role=="vendor")
                                            <p class="text-center">You have not yet enter a sale report, please add one</p>
                                            <button type="button" class="btn btn-success" id="addSaleReport">Add new sale report</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($sales_data as $sale)
                                @if($sale->created_at->format('Y') == $view_year)
                                    <tr>
                                        {{-- month column --}}
                                        <td class="align-middle text-left">
                                            <p class="text-xs font-weight-bold mb-0 text-upper"> {{ $sale->created_at->format('F') }}</p>
                                        </td>
                                        {{-- date added --}}
                                        <td class="align-middle text-left">
                                            <p class="text-xs font-weight-bold mb-0">{{ $sale->created_at->toDateString() }}</p>
                                        </td>
                                        {{-- date edited--}}
                                        <td class="align-middle text-left">
                                            <p class="text-xs font-weight-bold mb-0">{{ $sale->updated_at->toDateString() }}</p>
                                        </td>
                                        {{-- if the user if participant, allow edit sales data --}}
                                        @if($role == "student" || $role == "vendor")
                                            <td>
                                                <div class="action_buttons_div">
                                                    <button class="btn btn-icon btn-3 btn-secondary edit-btn" type="button" data-toggle="tooltip" data-placement="bottom" title="Edit sales data">
                                                        <span class="btn-inner--icon"><i class="fa fa-pencil"></i></span>
                                                        <span class="btn-inner--text">Edit</span>
                                                    </button>
                                                </div>
                                                <div class="edit-form-div" style="display: none;">
                                                    <form action="{{ route('update-sale-report') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <input type="text" name="report_ID" hidden value="{{ $sale->report_ID }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="cost_input">Cost:  </label>
                                                                    <input type="text" class="form-control" id="cost_input" name="cost_input" placeholder="RM0.00" value="{{  number_format($sale->cost,2)  }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="sale_input">Sale:  </label>
                                                                    <input type="text" class="form-control" id="sale_input" name="sale_input" placeholder="RM0.00" value="{{  number_format($sale->sales,2)  }}">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="submit" class="form-control btn btn-icon btn-3 btn-primary" value="Submit">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input type="datetime-local" class="form-control" name="date" value="{{ now()->format('Y-m-d\TH:i:s') }}" hidden>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                        @endif
                                            {{-- cost column --}}
                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">RM  {{  number_format($sale->cost,2) }}</p>
                                            </td>
                                            {{-- sales column --}}
                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">RM  {{  number_format($sale->sales,2) }}</p>
                                            </td>
                                            {{-- pupuk admin comment columns --}}
                                            <td class="action_column align-middle text-left">
                                                @if ($role == "student" or $role == "vendor")
                                                {{-- if user is participant, show the comment --}}
                                                    <div>
                                                        @if(empty($sale->comment))
                                                            <p>No comment yet</p>
                                                        @else
                                                            <p>{{ $sale->comment }}</p>
                                                            <div class="author align-items-center">
                                                                <div class="name ps-3">
                                                                    <div class="stats">
                                                                        <small>Posted on {{  $sale->comment_time  }}</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @elseif ($role == "pp_admin")
                                                {{-- if role is pupuk, show a form to submit comment --}}
                                                    <div>
                                                        <form action="{{ route('add-comment') }}" method="POST">
                                                            @csrf
                                                            <div class="form-group">
                                                                <input type="text" name="report_ID" hidden value="{{ $sale->report_ID }}">
                                                                <textarea class="form-control" id="pp_comment" rows="3" placeholder="Leave your comment here" name="pp_comment">{{  $sale->comment  }}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <input class="btn btn-icon btn-3 btn-primary" type="submit" value='Submit comment'>
                                                            </div>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                        @if($view_year == now()->year && $role != "pp_admin" && !empty($sale_data))
                            @php
                                $lastSale = $sales_data->last();
                                $lastSaleDate = \Carbon\Carbon::parse($lastSale->created_at);
                                $currentDate = \Carbon\Carbon::now();
                            @endphp
                            @if($lastSaleDate->lessThan($currentDate->startOfMonth()))
                                <tr id="newSaleReportRow">
                                    <td class="align-middle text-left">
                                        <p class="text-xs font-weight-bold mb-0 text-upper">{{ now()->format('F') }}</p>
                                    </td> <!-- Month name of current date -->
                                    <td class="align-middle text-left">
                                        <p class="text-xs font-weight-bold mb-0">{{ now()->toDateString() }}</p>
                                    </td> <!-- Current date -->
                                    <td></td> <!-- Empty column -->
                                    <td></td> <!-- Empty column -->
                                    <td>
                                        <form action="{{ route('submit-sale-report') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="sale_input" placeholder="RM0.00">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="submit" class="form-control btn btn-icon btn-3 btn-primary" value="Submit">
                                                    </div>
                                                    <div class="form-group">
                                                        <input type="datetime-local" class="form-control" name="date" value="{{ now()->format('Y-m-d\TH:i:s') }}" hidden>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    <td></td> <!-- Empty column -->
                                </tr>
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @include('layouts.footers.auth.footer')

    @if ($errors->any())
    <script>
        var errorMessage = "";
        @foreach ($errors->all() as $error)
            errorMessage += "{{ $error }}\n";
        @endforeach
        alert(errorMessage);
    </script>
    @endif
@endsection

@push('js')
{{-- bar chart script --}}
<script>
    salesData = {!! json_encode($sales_data) !!};

    // Function to group sales figures by month name
    function groupSalesFiguresByMonthName(salesData) {
        const groupedSalesFigures = {};

        // Filter sales data for the year
        const salesDataYear = salesData.filter(sale => {
            const date = new Date(sale.created_at);
            return date.getFullYear() === parseInt(document.getElementById('viewYear').value);
        });

        // Group sales figures by month name for the year 2023
        salesDataYear.forEach(sale => {
            const date = new Date(sale.created_at);
            const monthName = date.toLocaleString('default', { month: 'long' }); // Get month name

            if (!groupedSalesFigures[monthName]) {
                groupedSalesFigures[monthName] = 0;
            }

            groupedSalesFigures[monthName] += sale.sales;
        });

        return groupedSalesFigures;
    }

    function getTotalSalesPerYear(data) {
        const salesPerYear = {};

        data.forEach(item => {
            const year = new Date(item.created_at).getFullYear();

            if (!salesPerYear[year]) {
                salesPerYear[year] = 0;
            }

            salesPerYear[year] += item.sales;
        });

        return salesPerYear;
    }

    // Group the sales figures by year
    const totalSalesPerYear = getTotalSalesPerYear(salesData);

    // Group the sales figures by month name
    const groupedSalesFiguresByMonthName = groupSalesFiguresByMonthName(salesData);

    // Log the grouped sales data (for demonstration)
    console.log(groupedSalesFiguresByMonthName);

    // Extracting month names and sales figures from the object
    const month = Object.keys(groupedSalesFiguresByMonthName); // Array of month names
    const month_sale = Object.values(groupedSalesFiguresByMonthName); // Array of sales figures

    // Extracting year and sales figures from the object
    const year = Object.keys(totalSalesPerYear); // Array of year
    const year_sale = Object.values(totalSalesPerYear); // Array of sales figures

    var ctx1 = document.getElementById("bar-chart").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(251, 99, 64, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(251, 99, 64, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(251, 99, 64, 0)');

    let sale_chart = null;
    function createChart(labels, data) {
        if (sale_chart) {
            sale_chart.destroy(); // Destroy the existing chart if it exists
        }
        sale_chart = new Chart(ctx1, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Sales  ",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#fb6340",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: data,
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
    }

    function sort_by_year() {
        createChart(year, year_sale);
    }

    function sort_by_month() {
        createChart(month, month_sale);
    }

    // default view sort by month
    sort_by_month()
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addSaleReportBtn = document.getElementById('addSaleReport');
        const noSaleReport = document.getElementById('noSaleReport');
        const salesTableBody = document.querySelector('#salesTable tbody');

        addSaleReportBtn.addEventListener('click', function() {
            noSaleReport.style.display = 'none';
            const newRow = `
                <tr id="newSaleReportRow">
                    <td>{{ now()->format('F') }}</td> <!-- Month name of current date -->
                    <td>{{ now()->toDateString() }}</td> <!-- Current date -->
                    <td></td> <!-- Empty column -->
                    <td></td> <!-- Empty column -->
                    <td>
                        <form action="{{ route('submit-sale-report') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="cost_input">Cost:  </label>
                                        <input type="text" class="form-control" id="cost_input" name="cost_input" placeholder="RM0.00">
                                    </div>
                                    <div class="form-group">
                                        <label for="sale_input">Sale:  </label>
                                        <input type="text" class="form-control" id="sale_input" name="sale_input" placeholder="RM0.00">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="form-control btn btn-icon btn-3 btn-primary" value="Submit">
                                    </div>
                                    <div class="form-group">
                                        <input type="datetime-local" class="form-control" name="date" value="{{ now()->format('Y-m-d\TH:i:s') }}" hidden>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </td>
                    <td></td> <!-- Empty column -->
                </tr>
            `;

            // Append the new row to the table body
            salesTableBody.insertAdjacentHTML('beforeend', newRow);
        });
    });
</script>
{{-- replace edit button with edit form --}}
<script>
    $(document).ready(function() {
        $('.edit-btn').click(function() {
            $(this).closest('.action_buttons_div').hide();
            $(this).closest('td').find('.edit-form-div').show();
        });

        $('.edit-form').submit(function(event) {
            event.preventDefault();
            // Handle form submission here (e.g., update data via AJAX)
            // After handling the submission, you might want to hide the form again
            $(this).closest('.edit-form-div').hide();
            $(this).closest('td').find('.action_buttons_div').show();
        });
    });
</script>
@endpush
