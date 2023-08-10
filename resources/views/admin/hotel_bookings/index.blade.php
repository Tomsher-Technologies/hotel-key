@extends('admin.layouts.app')

@section('content')

<div class="content-body">
	<div class="container-fluid">
		<!-- <h3 class="head-title">Dashboard</h3> -->
		<div class="row">
			<div class="col-xl-12">
				<div class="row">
					<div class="col-xl-12">

                        <div class="card dz-card" id="bootstrap-table2">
                            <div class="card-header flex-wrap d-flex justify-content-between">
                                <div>
                                    <h3 class="card-title main-head">All Bookings</h3>
                                </div>
                                <a href="{{ route('add-booking') }}" class="btn btn-primary">Add New Booking</a>
                            </div>
							 <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                                <th class="text-center"><strong>Sl No.</strong></th>
                                                <th><strong>Main User</strong></th>
                                                <th class="text-center"><strong>Room Number</strong></th>
                                                <th class="text-center"><strong>Check-In</strong></th>
                                                <th class="text-center"><strong>Check-Out</strong></th>
                                                <th><strong>Additional Users</strong></th>
                                                <th><strong>Additional Facilities</strong></th>
                                                <th class="text-center"><strong>Status</strong></th>
                                                <th><strong>Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($bookings[0]))
                                                @foreach($bookings as $key => $book)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                                                        <td><strong>{{ $book->main_user->name ?? '' }}</strong></td>
                                                        <td class="text-center">
                                                            {{ $book->room_number }}
                                                        </td>
                                                        <td class="text-center">{{ $book->checkin_date }} {{ $book->checkin_time }}</td>
                                                        <td class="text-center">{{ $book->checkout_date }} {{ $book->checkout_time }}</td>
                                                        <td>
                                                            @if(isset($book->additional_users_without_main_user[0]))
                                                                <ul class="list-icons">
                                                                @foreach($book->additional_users_without_main_user as $adUser)
                                                                    <li><i class="fa fa-caret-right text-black-50"></i> {{ $adUser->user->name ?? '' }}</li>
                                                                @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($book->booking_facilities[0]))
                                                                <ul class="list-icons">
                                                                @foreach($book->booking_facilities as $adFac)
                                                                    <li><i class="fa fa-caret-right text-black-50"></i> {{ $adFac->facilities->facility_name ?? '' }}</li>
                                                                @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($book->is_active == 1)
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fa fa-circle text-success me-1"></i>
                                                                    Active
                                                                </div>
                                                            @else
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fa fa-circle text-danger me-1"></i>
                                                                    In-Active
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-primary light shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                                                <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="9" class="text-center">No data found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
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

@endsection

@section('footer')
<script type="text/javascript">

</script>
@endsection