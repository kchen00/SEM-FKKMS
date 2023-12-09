{{-- inteface for pupuk admin to select which kiosk sale report to view --}}
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@php
    // hardcoded variable values, remove when doing controller
    $kiosk_id_owner = array(
        (object)["id" => "123", "name" => "James"],
        (object)["id" => "456", "name" => "Sarah"],
        (object)["id" => "789", "name" => "John"],
        (object)["id" => "246", "name" => "Emily"],
        (object)["id" => "135", "name" => "Michael"],
        (object)["id" => "579", "name" => "Emma"],
        (object)["id" => "802", "name" => "Olivia"],
        (object)["id" => "375", "name" => "William"],
        (object)["id" => "987", "name" => "Sophia"],
        (object)["id" => "642", "name" => "Alexander"]
    );


@endphp
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
                        </tr>
                    </thead>
                    <tbody>
                        {{-- dynamically generate table rows --}}
                        @for ($i = 0; $i < count($kiosk_id_owner); $i++)
                            <tr>
                                <!-- KIOSK ID column-->
                                <td class="align-middle text-left">
                                    <p class="text-xs font-weight-bold text-uppercase mb-0 ">{{  $kiosk_id_owner[$i] -> id }}</p>
                                </td>

                                <!-- KIOSK owner column -->
                                <td class="align-middle text-left">
                                    <p class="text-xs font-weight-bold mb-0">{{  $kiosk_id_owner[$i] -> name }}</p>
                                </td>

                                <!-- action column -->
                                <td class="align-middle text-left">
                                    <a href="{{ route('show-report')}}" class="btn btn-primary active" role="button" aria-pressed="true">
                                        <span class="btn-inner--icon"><i class="fas fa-search"></i></span>
                                        <span class="btn-inner--text">View</span>
                                    </a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@include('layouts.footers.auth.footer')
@endsection
