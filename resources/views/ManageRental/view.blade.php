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
                            <p class="mb-0">Kiosk Rental</p>
                            @if($rental)
                            <div class="d-flex align-items-center">
                                <button class="btn btn-primary btn-sm mx-1" type="button" onclick="window.location='{{route('rental.edit',$rental['rentals_ID'])}}'">Edit</button>
                                <button class="btn btn-success btn-sm mx-1" type="button" onclick="window.location=''">Payment</button>
                            </div>
                            @endif
                        </div>
                        
                        
                        @if($rental)
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" type="text" name="username" value="{{ old('username', auth()->user()->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Kiosk Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Description</label>
                                        <label class="form-control">{{$rental['description']}}</label>
                                        {{-- <textarea class="form-control" name="description" rows="3"></textarea> --}}
                                      </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Start Date</label>
                                        <label class="form-control">{{$rental['startdate']}}</label>
                                        {{-- <input class="form-control" type="date"  name="startdate"> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">End Date</label>
                                        <label class="form-control">{{$rental['enddate']}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Kiosk</label>
                                        <label class="form-control">{{$rental->Kiosk->description}}</label>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label">SSM</label>
                                        <input class="form-control" type="file" name="SSM">
                                    </div>
                                </div> --}}
                                <div class="col-md-4">
                                    {{-- <div class="form-group">
                                        <label class="form-control-label">SSM</label>
                                        <input class="form-control" type="file" name="SSM"
                                            value="{{ old('SSM', $rental['SSM']) }}">
                                    </div> --}}
                                    @if ($rental['SSM'])
                                        <a class="btn btn-primary"
                                            href="{{ route('file.display', ['fileName' => $rental['SSM']]) }}"
                                            target="_blank">View File</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="card-body">

                            No On Going Rental, please make an application or wait for application approval
                        </div>
                        @endif
                    </form>
                </div>
            </div> 
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
