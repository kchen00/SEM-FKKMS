@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tables'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6>payments</h6>
                            </div>
                            {{-- <div class="col-auto">
                                <button class="btn btn-success" type="button" onclick="window.location='{{ route('payment.create') }}'">Button</button>
                            </div> --}}
                        </div>
                    </div>
                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                    </div>
                @endif
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            payment</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date Apply</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <img src="/img/team-2.jpg" class="avatar avatar-sm me-3" alt="user1">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{$payment->participant->user->username}}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{$payment['notes']}}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{$payment['created_at']}}</p>
                                            {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-success">{{$payment['status']}}</span>
                                        </td>
                                        {{-- <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                                        </td> --}}
                                        <td class="align-middle text-center">
                                            @if($payment['status']==='accepted' || $payment['status']==='rejected')
                                            <span class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user" style="cursor: not-allowed;">
                                                closed
                                            </span>
                                            @else
                                            <a href="{{route('payment.adminEdit', $payment['payment_ID'])}}" class="btn btn-info"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                Edit
                                            </a>
                                            @endif
                                            <a href="{{route('payment.adminEdit', $payment['payment_ID'])}}" class="btn btn-success"
                                                data-toggle="tooltip" data-original-title="Edit user">
                                                view
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
