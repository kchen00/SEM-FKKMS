@if(session('success'))
    <script>
        // Display a JavaScript popup on successful user addition
        alert("{{ session('success') }}");
    </script>   
@endif
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Add new user'])


<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card bg-secondary">
                <div class="card-header p-0 mx-3 mt-3 position-relative z-index-1 bg-secondary">
                    <h1 class="card-title d-block text-white text-center">
                        Add new user
                    </h1>
                    <p class="card-description mb-4 text-center text-white">
                        Enter the information required.
                    </p>
                </div>
                <div class="card-body pt-2 col-md-8 mx-auto">      
                    <form method="POST" action="{{ route('admin-add-user.perform') }}">
                        @csrf
                        <!-- email input -->
                        <div class="flex flex-col mb-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" value="{{ old('email') }}" >
                            @error('email') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- username input -->
                        <div class="flex flex-col mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Name" value="{{ old('username') }}" >
                            @error('username') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- phone number input -->
                        <div class="flex flex-col mb-3">
                            <input type="text" name="phone_num" class="form-control" placeholder="Phone number" aria-label="Phone" value="{{ old('phone_num') }}" >
                            @error('phone_num') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- password input -->
                        <div class="flex flex-col mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password">
                            @error('password') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- confirm password input -->
                        <div class="flex flex-col mb-3">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" aria-label="Password">
                            @error('password') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- user type drop down -->
                        <div class="flex flex-col mb-3">
                            <select name="role" class="form-control" placeholder="Select user group">
                                <option selected disabled>Select user group</option>
                                <option value="admin">Admin</option>
                                <option value="tech_team">Technical Team</option>
                                <option value="pp_admin">PUPUK Admin</option>
                                <option value="bursary">Bursary</option>
                            </select>
                            @error('role') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- student matric input -->
                        <div id="matric_number" class="flex flex-col mb-3" style="display: none;">
                            <input type="text" name="matric_number" class="form-control" placeholder="Enter matric number" aria-label="Matric number">
                            @error('matric_number') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- ic number  input -->
                        <div id="ic_number" class="flex flex-col mb-3" style="display: none;">
                            <input type="text" name="ic_number" class="form-control" placeholder="Enter IC number" aria-label="IC number">
                            @error('ic_number') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- t and c confirm -->
                        <div class="form-check form-check-info text-start d-none">
                            <input class="form-check-input" type="checkbox" name="terms" id="flexCheckDefault" checked>
                            <label class="form-check-label" for="flexCheckDefault">
                                I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and
                                    Conditions</a>
                            </label>
                            @error('terms') <p class='text-danger text-xs'> {{ $message }} </p> @enderror
                        </div>
        
                        <!-- submit button -->
                        <div class="text-center">
                            <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Register new user</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div> 
@include('layouts.footers.auth.footer')
@endsection


