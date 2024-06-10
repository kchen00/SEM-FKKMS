{{-- inteface for pupuk admin to select which kiosk sale report to view --}}
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Select a KIOSK'])

    <div class="container-fluid py-4">
        <!-- table for sales entry -->
        <div class="card m-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-2">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">KIOSK ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">KIOSK owner</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">LAST UPDATE</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- dynamically generate table rows --}}
                        @foreach($kiosk_id_owner as $kioskId => $data)
                            <tr>
                                <!-- KIOSK ID column-->
                                <td class="align-middle text-left">
                                    <p class="text-xs font-weight-bold text-uppercase mb-0">{{ $kioskId }}</p>
                                </td>

                                <!-- KIOSK owner column -->
                                <td class="align-middle text-left">
                                    <p class="text-xs font-weight-bold mb-0">{{ $data['username'] }}</p>
                                </td>

                                <!-- action column -->
                                <td class="align-middle text-left">
                                    <a href="{{ route('admin-show-report', ["participant_id"=>$data['parti_id'], "kiosk_id"=>$kioskId, "kiosk_owner"=>$data['username']]) }}" class="btn btn-primary active" role="button" aria-pressed="true">
                                        <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                                        <span class="btn-inner--text">View</span>
                                    </a>
                                </td>

                                {{-- last updated --}}
                                <td class="align-middle text-middle">
                                    {{ $data['updated_at'] }} @if($data['just_updated'])<span class="badge bg-gradient-success">Just updated</span>@endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@include('layouts.footers.auth.footer')
@endsection
