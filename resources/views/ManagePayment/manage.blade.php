@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Payment'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6>Payments</h6>
                            </div>
                            @if ($datas['balance'] > 0)
                                <div class="col-auto">
                                    <button class="btn btn-success" type="button"
                                        onclick="window.location='{{ route('payment.create') }}'">New</button>
                                </div>
                            @endif
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <p class="text-xs text-secondary mb-0">
                            Total Payment</p>
                        <h6 class="mb-0 text-sm">RM {{ $datas['total'] }}</h6>
                        <p class="text-xs text-secondary mb-0">
                            Total Invoice</p>
                        <h6 class="mb-0 text-sm">RM {{ $datas['totalRent'] }}</h6>
                        <p class="text-xs text-secondary mb-0">
                            Unpaid Balance</p>
                        <h6 class="mb-0 text-sm">RM {{ $datas['balance'] }}</h6>
                        <p class="text-xs text-secondary mb-0">
                            Pending Payment</p>
                        <h6 class="mb-0 text-sm">RM {{ $datas['pendingPayment'] }}</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Amount</th>
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
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        <img src="/img/team-2.jpg" class="avatar avatar-sm me-3"
                                                            alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">RM {{$payment['amount']}}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ $payment['created_at'] }}
                                                </p>
                                                {{-- <p class="text-xs text-secondary mb-0">Organization</p> --}}
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm bg-gradient-success">{{ $payment['status'] }}</span>
                                            </td>
                                            {{-- <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">23/04/18</span>
                                        </td> --}}
                                            <td class="align-middle text-center">
                                                {{-- <a class="btn btn-info"
                                                    href="{{ route('payment.edit', $payment['payment_ID']) }}"
                                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                    data-original-title="Edit user">
                                                    Edit
                                                </a> --}}
                                                <a class="btn btn-success" href="{{route('payment.show', $payment['payment_ID'])}}"
                                                    class="text-secondary font-weight-bold text-xs" data-toggle="tooltip"
                                                    data-original-title="Edit user">
                                                    View
                                                </a>
                                                @if ($payment['payment_proof']) 
                                                <a class="btn btn-primary"
                                                    href="{{ route('file.display', ['fileName' => $payment['payment_proof']]) }}" 
                                                    target="_blank">View File</a>
                                                    @endif
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
