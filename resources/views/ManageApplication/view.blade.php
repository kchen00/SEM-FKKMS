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
                    <form role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Kiosk Application</p>
                                @if(auth()->user()->role=='admin')
                                <button type="button" class="btn btn-primary btn-sm ms-auto" onclick="window.location='{{ route('application.adminManage') }}'">back</button>
                                @else
                                <button type="button" class="btn btn-primary btn-sm ms-auto" onclick="window.location='{{ route('application.manage') }}'">back</button>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" disabled type="text" name="username" value="{{ old('username', auth()->user()->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" disabled type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Kiosk Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Description</label>
                                        <textarea class="form-control" disabled name="description" rows="3">{{$application['description']}} </textarea>
                                      </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Start Date</label>
                                        <input class="form-control" disabled type="date" value="{{ date('Y-m-d', strtotime($application['startdate'])) }}" name="startdate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">End Date</label>
                                        <input class="form-control" disabled type="date" value="{{ date('Y-m-d', strtotime($application['enddate'])) }}" name="enddate">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if ($application['SSM'])
                                    <div class="form-group">
                                       
                                        <label class="form-control-label">SSM</label>
                                        <div class="form-control-label">

                                            <a class="btn btn-primary"
                                                href="{{ route('file.display', ['fileName' => $application['SSM']]) }}"
                                                target="_blank">View File</a>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
