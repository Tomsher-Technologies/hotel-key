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

                            </div>
							 <div class="card-body">
                                
                                <form  action="" method="GET">
                                    <div class="row search-section">
                                        <div class="mb-3 col-sm-3">
                                            <label class="form-label">Hotel</label>
                                            <select class="me-sm-2 select2 form-control wide" style="width:100% !important;" name="hotel"  id="hotel">
                                                <option value=""> Select </option>
                                                @foreach($hotels as $hote)
                                                    <option {{ ($hotel_search == $hote->id) ? 'selected' : '' }} value="{{$hote->id}}">{{$hote->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3 col-sm-3">
                                            <label class="form-label">User</label>
                                            <select class="me-sm-2 select2 form-control wide" style="width:100% !important;" name="user"  id="user">
                                                <option value=""> Select </option>
                                                @foreach($users as $user)
                                                    <option {{ ($user_search == $user->id) ? 'selected' : '' }} value="{{$user->id}}">{{$user->name}}  ({{$user->email}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-2">
                                            <label class="form-label">Check-In Date</label>
                                            <input type="text" class="form-control" value="{{ $checkin_search }}" id="checkin" name="checkin"
                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                        </div>
                                        <div class="mb-3 col-sm-2">
                                            <label class="form-label">Check-Out Date</label>
                                            <input type="text" class="form-control" value="{{ $checkout_search }}" id="checkout" name="checkout"
                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                        </div>
                                        <div class="mb-3 col-sm-2 margin-auto">
                                            <button class="btn btn-primary light" type="submit">Search</button>
                                            <a href="{{ route('bookings') }}" class="btn btn-danger light" type="button">Reset</a>
                                        </div>
                                    
                                    </div>
                                </form>
                            
                                
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                                <th class="text-center"><strong>Sl No.</strong></th>
                                                <th><strong>Hotel Name</strong></th>
                                                <th><strong>Master User</strong></th>
                                                <th class="text-center"><strong>Room Number</strong></th>
                                                <th class="text-center"><strong>Check-In</strong></th>
                                                <th class="text-center"><strong>Check-Out</strong></th>
                                                <th><strong>Additional Users</strong></th>
                                                <th><strong>Additional Facilities</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($bookings[0]))
                                                @foreach($bookings as $key => $book)
                                                    <tr>
                                                        <td class="text-center">{{ $key + 1 + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                                                        <td><strong>{{ $book->hotel->name ?? '' }}</strong></td>
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
                                                       
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">No data found.</td>
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
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-datetimepicker.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endsection

@section('footer')
<script src="{{ asset('assets/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script type="text/javascript">
     $('#hotel').select2({
        'placeholder':'Select'
    });
    $('#user').select2({
        'placeholder':'Select'
    });
     $('#checkin').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: true
    });
    $('#checkout').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: true
    });
   
</script>
@endsection