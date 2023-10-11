@extends('admin.layouts.app')
@section('title', 'All Access')
@section('content')

<div class="content-body">
	<div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card border-0">
                    <div class="card-header border-0">
                        <div>
                            <!-- <h3 class="card-title main-head">Update Access</h3> -->
                        </div>
                        <a href="{{ route('all-bookings') }}" class="btn btn-primary">Back</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12  col-lg-6">
                                <div class="card">
                                    <div class="card-header border-0  pb-0">
                                        <h3 class=""><strong>Access Details</strong></h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered font-13" >
                                                <tbody>
                                                    <tr>
                                                        <th class="text-nowrap text-dark w-30" scope="row">Master User</th>
                                                        <td>{{ $access->main_user->name ?? ''  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap text-dark w-30" scope="row">Room Number</th>
                                                        <td>{{ $access->room_number ?? ''  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap text-dark w-30" scope="row">Access-In</th>
                                                        <td>
                                                            {{ date('d M, Y  h:i a', strtotime($access->checkin)) }} 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap text-dark w-30" scope="row">Access-Out</th>
                                                        <td>{{ date('d M, Y  h:i a', strtotime($access->checkout)) }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap text-dark w-30" scope="row">Other Facilities</th>
                                                        <td>
                                                            @if(isset($access->booking_facilities[0]))
                                                                <ul class="list-icons">
                                                                @foreach($access->booking_facilities as $adFac)
                                                                    <li><i class="fa fa-caret-right text-black"></i> {{ $adFac->facilities->facility_name ?? '' }}</li>
                                                                @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-nowrap text-dark w-30" scope="row">Additional Users</th>
                                                        <td>
                                                            @if(isset($access->additional_users_without_main_user[0]))
                                                                <ul class="list-icons">
                                                                @foreach($access->additional_users_without_main_user as $adUser)
                                                                    <li><i class="fa fa-caret-right text-black"></i> {{ $adUser->user->name ?? '' }}</li>
                                                                @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12  col-lg-6">
                                <div class="card">
                                    <div class="card-header border-0  pb-0">
                                        <h3 class=""><strong>History</strong></h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div id="DZ_W_TimeLine" class="widget-timeline dz-scroll height450 my-4 px-4">
                                            <ul class="timeline">
                                                <li>
                                                    <div class="timeline-badge primary"></div>
                                                    <a class="timeline-panel " href="#">
                                                        <div class="header-info2 d-flex align-items-center">
                                                            <div class="header-media">
                                                                <img src="{{ asset('assets/images/cl1.png') }}" class="avatar avatar-lg" alt="">
                                                            </div>
                                                            <div class="header-info">
                                                                <h6 class="mb-0">Check In</h6>
                                                                <span>{{ date('d M, Y  h:i a', strtotime($access->checkin)) }} </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <div class="timeline-badge info"></div>
                                                    <a class="timeline-panel " href="#">
                                                        <div class="header-info2 d-flex align-items-center">
                                                            <div class="header-media">
                                                                <img src="{{ asset('assets/images/cn1.png') }}" class="avatar avatar-lg" alt="">
                                                            </div>
                                                            <div class="header-info">
                                                                <h6 class="mb-0">Door Opened : Housekeeping</h6>
                                                                <span>{{ date('d M, Y  h:i a', strtotime($access->checkin)+3600) }} </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>

                                                <li>
                                                    <div class="timeline-badge info"></div>
                                                    <a class="timeline-panel " href="#">
                                                        <div class="header-info2 d-flex align-items-center">
                                                            <div class="header-media">
                                                                <img src="{{ asset('assets/images/uc1.png') }}" class="avatar avatar-lg" alt="">
                                                            </div>
                                                            <div class="header-info">
                                                                <h6 class="mb-0">Door Opened : John Wick</h6>
                                                                <span>{{ date('d M, Y  h:i a', strtotime($access->checkin)+10000) }} </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>

                                                <li>
                                                    <div class="timeline-badge danger"></div>
                                                    <a class="timeline-panel " href="#">
                                                        <div class="header-info2 d-flex align-items-center">
                                                            <div class="header-media">
                                                                <img src="{{ asset('assets/images/gh1.png') }}" class="avatar avatar-lg" alt="">
                                                            </div>
                                                            <div class="header-info">
                                                                <h6 class="mb-0">Door Opened : Unknown</h6>
                                                                <span>{{ date('d M, Y  h:i a', strtotime($access->checkin)+15000) }}</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        
        
    </div>
</div>

@endsection
@section('header')
<style>
.statusBooking{
    line-height: 11px !important;
    padding: 0.438rem 0.5rem !important;
    border-radius: 0.4rem !important;
}
</style>
@endsection

@section('footer')

@endsection