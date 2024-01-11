@php
    $role = Auth::user()->role;
@endphp

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ route('dashboard') }}" target="_blank">
            <img src="/img/FKKMS favicon.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">FKKMS</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- dashboard side nav -->
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <!-- sales report side nav -->
            @if ($role == "student" or $role == "vendor")
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'show-report' ? 'active' : '' }}" href="{{ route('show-report') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chart-bar-32 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sales Report</span>
                </a>
            </li>
            @endif

            @if ($role == "pp_admin")
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'show-kiosk' ? 'active' : '' }}" href="{{ route('show-kiosk') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chart-bar-32 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sales Report</span>
                </a>
            </li>
            @endif

            <!-- manage application side nav -->
            @if ($role == "student" or $role == "vendor" or $role == "admin")
            <li class="nav-item">
                @if($role == "admin")
                <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'application') ? 'active' : '' }}" href="{{ route('application.adminManage') }}">
                @else
                <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'application') ? 'active' : '' }}" href="{{ route('application.manage') }}">
                @endif
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-file-text text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Application</span>
                </a>
            </li>
            @endif

            <!-- manage rental side nav -->
            @if ($role == "student" or $role == "vendor" or $role == "admin")
            <li class="nav-item">
                @if($role == "admin")
                <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'rental') ? 'active' : '' }}" href="{{ route('rental.adminManage') }}">
                @else
                <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'rental') ? 'active' : '' }}" href="{{ route('rental') }}">
                @endif
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-basket text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Rental</span>
                </a>
            </li>
            @endif

            <!-- manage complaints side nav -->
            @if ($role == "student" or $role == "vendor" or $role == "tech_team")
            <li class="nav-item">
                <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'complaint') ? 'active' : '' }}" href="{{ route('complaint-menu') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chat-round text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Complaints</span>
                </a>
            </li>
            @endif
            
            <!-- add user side nav -->
            @if ($role == "admin")
            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'admin-add-user' ? 'active' : '' }}" href="{{ route('admin-add-user') }}">
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-chat-round text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Add New User</span>
                </a>
            </li>
            @endif

            {{-- manage payment side nav --}}
            @if ($role == "student" or $role == "vendor" or $role == "bursary")
            <li class="nav-item">
                @if($role == "bursary")
                <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'payment') ? 'active' : '' }}" href="{{ route('payment.bursaryManage')  }}">
                @else
                <a class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'payment') ? 'active' : '' }}" href="{{ route('payment') }}">
                @endif
                    <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-money text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manage Payments</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</aside>