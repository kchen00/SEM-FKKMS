@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Your Profile'])
    <div id="alert">
        @include('components.alert')
    </div>
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form role="form" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Kiosk Rental</h6>
                            @if($rental)
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-primary btn-sm mx-1" type="button" onclick="window.location='{{ route('rental.edit', $rental['rentals_ID']) }}'">Edit</button>
                                    <button class="btn btn-success btn-sm mx-1" type="button" onclick="window.location='{{ route('payment') }}'">Payment</button>
                                </div>
                            @endif
                        </div>
                        
                        @if($rental)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="text-uppercase text-sm mb-0">User Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="username" class="form-control-label">Username</label>
                                                        <input class="form-control" id="username" disabled type="text" name="username" value="{{ old('username', auth()->user()->username) }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="email" class="form-control-label">Email address</label>
                                                        <input class="form-control" id="email" disabled type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="text-uppercase text-sm mb-0">Kiosk Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description" class="form-control-label">Description</label>
                                                        <div class="border p-2">{{ $rental['description'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="startdate" class="form-control-label">Start Date</label>
                                                        <div class="border p-2">{{ $rental['startdate'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="enddate" class="form-control-label">End Date</label>
                                                        <div class="border p-2">{{ $rental['enddate'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="kiosk" class="form-control-label">Kiosk</label>
                                                        <div class="border p-2">{{ $rental->Kiosk->description }}</div>
                                                    </div>
                                                </div>
                                                @if ($rental['SSM'])
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="ssm" class="form-control-label">SSM</label>
                                                            <div class="form-control-label">
                                                                <a class="btn btn-primary" href="{{ route('file.display', ['fileName' => $rental['SSM']]) }}" target="_blank">View File</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                No ongoing rental. Please make an application or wait for application approval.
                            </div>
                        </div>
                        @endif
                    </form>
                </div>
            </div> 
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
