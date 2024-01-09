@extends('layouts.app')

@include('layouts.navbars.guest.navbar')

{{-- js to dynamically render and hide matric and ic input field --}}
@push("js")
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var userRole = document.getElementById('userRole');
        var matricField = document.getElementById('matric_number');
        var icField = document.getElementById('ic_number');

        // Function to check and render the additional input field based on the initial value
        function renderAdditionalInput() {
            var selectedValue = userRole.value;

            // Check the selected value and show/hide the additional input field
            if (selectedValue === 'student') {
                matricField.style.display = 'block';
                icField.style.display = 'none';
            }
            
            if (selectedValue === 'vendor') {
                matricField.style.display = 'none';
                icField.style.display = 'block';
            }
        }

        // Render the additional input field immediately after the DOM is loaded
        renderAdditionalInput();

        // Event listener to handle changes in the dropdown
        userRole.addEventListener('change', function() {
            renderAdditionalInput(); // Call the function on dropdown change
        });
    });
</script> 
@endpush   

@section('content')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('/img/register_banner.jpg'); background-position: bottom;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome to FKKMS!</h1>
                        <p class="text-lead text-white">To get started, create your account here for seamless access to our services. Let's begin your journey with us!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-body">
                            <form method="POST" action="{{ route('register.perform') }}">
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
                                    <select name="role" class="form-control" placeholder="Select user group" id="userRole">
                                        <option selected disabled>Select your user group</option>
                                        <option value="student">Student</option>
                                        <option value="vendor">Outside Vendor</option>
                                    </select>
                                    @error('role') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>

                                <!-- student matric input -->
                                <div id="matric_number" class="flex flex-col mb-3" style="display: none;">
                                    <input type="text" name="matric_number" class="form-control" placeholder="Enter your matric number" aria-label="Matric number">
                                    @error('matric_number') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>

                                <!-- ic number  input -->
                                <div id="ic_number" class="flex flex-col mb-3" style="display: none;">
                                    <input type="text" name="ic_number" class="form-control" placeholder="Enter your IC number" aria-label="IC number">
                                    @error('ic_number') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
                                </div>

                                <!-- t and c confirm -->
                                <div class="form-check form-check-info text-start">
                                    <input class="form-check-input" type="checkbox" name="terms" id="flexCheckDefault" >
                                    <label class="form-check-label" for="flexCheckDefault">
                                        I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and
                                            Conditions</a>
                                    </label>
                                    @error('terms') <p class='text-danger text-xs'> {{ $message }} </p> @enderror
                                </div>

                                <!-- submit button -->
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                                </div>

                                <!-- sign in instruction -->
                                <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('login') }}"
                                        class="text-dark font-weight-bolder">Sign in</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection
