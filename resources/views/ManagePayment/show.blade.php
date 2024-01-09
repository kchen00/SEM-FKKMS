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
                    <form role="form" method="POST" action={{ route('payment.bursaryUpdate', $payment['payment_ID']) }}
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Kiosk payment</p>
                                <a href="@if (auth()->user()->role == 'bursary') {{route('payment.bursaryManage')}} @else
                                    {{route('payment')}} @endif" class="btn btn-primary btn-sm ms-auto"
                                    data-toggle="tooltip" data-original-title="Edit user">
                                    Back
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input disabled class="form-control" type="text" name="username"
                                            value="{{ old('username', auth()->user()->username) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input disabled class="form-control" type="email" name="email"
                                            value="{{ old('email', auth()->user()->email) }}">
                                    </div>
                                </div>
                            </div>
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Payment Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Note</label>
                                        <textarea class="form-control" name="notes" rows="3" disabled value="{{ $payment['notes'] }}">{{ old('notes', $payment['notes']) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Feedback</label>
                                        <textarea class="form-control" name="feedback" rows="3" disabled>{{ $payment['feedback'] }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Amount</label>
                                        <input class="form-control" name="amount" value="RM {{ $payment['amount'] }}"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Payment Date</label>
                                        <input class="form-control" type="date" name="created_at"
                                            value="{{ date('Y-m-d', strtotime($payment['created_at'])) }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Payment Proof</label>
                                        <div class="row">
                                            @if ($payment['payment_proof'])
                                                <a class="btn btn-primary"
                                                    href="{{ route('file.display', ['fileName' => $payment['payment_proof']]) }}"
                                                    target="_blank">View File</a>
                                            @endif
                                        </div>
                                        {{-- <input class="form-control" type="file" name="SSM"
                                            value="{{ old('SSM', $payment['SSM']) }}"> --}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Select Option</label>
                                    <input class="form-control" name="status" value="{{ $payment['status'] }}" disabled>
                                    <!-- Add more options as needed -->
                                    </select>
                                </div>
                                <div class="form-group" id="kioskSelect" style="display: none;">
                                    <label>Kiosks</label>


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
