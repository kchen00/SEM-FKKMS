@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Reset password'])
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card bg-secondary">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-start bg-secondary">
                        <h4 class="font-weight-bolder text-white">Change password</h4>
                        <p class="mb-0 text-white">This is your first time login, please reset your password</p>
                    </div>
                    <div class="card-body">
                        <form role="form" method="POST" action="{{ route('admin-force-reset.perform') }}">
                            @csrf
                            <div class="flex flex-col mb-3">
                                <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="{{ Auth::user()->email }}" aria-label="Email" readonly>
                                @error('email') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                            </div>
                            <div class="flex flex-col mb-3">
                                <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" >
                                @error('password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                            </div>
                            <div class="flex flex-col mb-3">
                                <input type="password" name="confirm-password" class="form-control form-control-lg" placeholder="Confirm Password" aria-label="Password"  >
                                @error('confirm-password') <p class="text-danger text-xs pt-1"> {{$message}} </p>@enderror
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Reset password</button>
                            </div>
                        </form>
                    </div>
                    <div id="alert">
                        @include('components.alert')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@include('layouts.footers.auth.footer') 
@endsection