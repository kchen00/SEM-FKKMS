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
                    <form role="form" method="POST"
                        action={{ route('rental.adminUpdate', $rental['rentals_ID']) }}
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Kiosk rental</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" type="text" name="username"
                                            value="{{ old('username', auth()->user()->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email"
                                            value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Kiosk Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description', $rental['description']) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Start Date</label>
                                        <input class="form-control" type="date" name="startdate" value="{{date('Y-m-d', strtotime($rental['startdate']))}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">End Date</label>
                                        <input class="form-control" type="date" name="enddate" value="{{date('Y-m-d', strtotime($rental['enddate']))}}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">SSM</label>
                                        <input class="form-control" type="file" name="SSM"
                                            value="{{ old('SSM', $rental['SSM']) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Select Option</label>
                                    <select class="form-control" name="status" id="statusSelect">
                                        {{-- <option disabled selected>Select status</option> --}}
                                        <option value="on going"  {{ $rental['status'] == 'on going' ? 'selected' : '' }}>on going</option>
                                        <option value="terminated"  {{$rental['status'] == 'terminated' ? 'selected' : '' }}>terminate</option>
                                        <!-- Add more options as needed -->
                                    </select>
                                </div>
                                <div class="form-group" id="kioskSelect" style="display: none;">
                                    <label>Kiosks</label>

                                    <select class="form-control" name="kiosk" required>
                                        <option disabled selected value="">Select Kiosk</option>
                                        @foreach ($kiosks as $kiosk)
                                            <option value="{{ $kiosk['kiosk_ID'] }}">{{ $kiosk['description'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <script>
                                    document.getElementById('statusSelect').addEventListener('change', function() {
                                        var status = this.value;
                                        var kioskSelect = document.querySelector('#kioskSelect select[name="kiosk"]');

                                        if (status === 'accepted') {
                                            kioskSelect.closest('.form-group').style.display = 'block'; // Show the second dropdown
                                            kioskSelect.setAttribute('required', 'required'); // Set 'required' attribute
                                        } else {
                                            kioskSelect.closest('.form-group').style.display = 'none'; // Hide the second dropdown
                                            kioskSelect.removeAttribute('required'); // Remove 'required' attribute
                                        }
                                    });
                                </script>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
