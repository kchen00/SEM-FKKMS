@extends('layouts.app')

@include('layouts.navbars.guest.navbar')

@section('content')
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://scontent.fkul21-2.fna.fbcdn.net/v/t39.30808-6/305837708_570654004860041_5002931631043837671_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=5f2048&_nc_ohc=ZGs4ohw3K4IAX-qH2WP&_nc_ht=scontent.fkul21-2.fna&oh=00_AfBGiyPO9Lv5aq6CtmuZMigxER6aZjPvU5OVQQJ9HJ2VLw&oe=65644AC3'); background-position: bottom;">
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
                                    @error('phone_number') <p class='text-danger text-xs pt-1'> {{ $message }} </p> @enderror
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
