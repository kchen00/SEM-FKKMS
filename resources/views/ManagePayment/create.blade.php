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
                    <form role="form" method="POST" action={{ route('payment.store') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Payment Application</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <hr class="horizontal dark">
                            <p class="text-uppercase text-sm">Payment Information</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">notes</label>
                                        <textarea class="form-control" name="notes" rows="3"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Amount (RM)</label>
                                        <input class="form-control" name="amount" rows="3" type="number">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label">Payment Proof</label>
                                        {{-- <input class="form-control" type="file" name="SSM"> --}}
                                        <input type="file" id="file" class="form-control" name="file"
                                            placeholder="document" accept=".pdf">

                                        <script>
                                            // JavaScript function to validate file extension
                                            function validateFileExtension() {
                                                var allowedExtensions = /(\.pdf)$/i; // Regular expression to allow only PDF files

                                                var fileInput = document.getElementById('file');
                                                var filePath = fileInput.value;
                                                var fileExtension = filePath.substr(filePath.lastIndexOf('.')).toLowerCase();

                                                if (!allowedExtensions.exec(fileExtension)) {
                                                    alert('Only PDF files are allowed.');
                                                    fileInput.value = ''; // Clear the file input value
                                                    return false;
                                                }

                                                return true;
                                            }
                                        </script>
                                    </div>
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
