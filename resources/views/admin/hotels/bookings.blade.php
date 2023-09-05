@extends('admin.layouts.app')
@section('title', 'All Access')
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
                                    <h3 class="card-title main-head">All Access</h3>
                                </div>

                            </div>
							 <div class="card-body">
                                @php
                                    if($user_search){
                                        $mUser = array($user_search);
                                        $mainUser = getUserDetails($mUser);
                                        $userOptions = '<option value="'. $mainUser[0]->id .'" selected>'.$mainUser[0]->name.'-'.$mainUser[0]->profile_id.' ('.$mainUser[0]->email.')</option>';
                                    }else{
                                        $userOptions = '';
                                    }
                                @endphp
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
                                               
                                            </select>
                                        </div>
                                        <div class="mb-3 col-sm-3">
                                            <label class="form-label">Access-In Date</label>
                                            <input type="text" class="form-control" value="{{ $checkin_search }}" id="checkin" name="checkin"
                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                        </div>
                                        <div class="mb-3 col-sm-3">
                                            <label class="form-label">Access-Out Date</label>
                                            <input type="text" class="form-control" value="{{ $checkout_search }}" id="checkout" name="checkout"
                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                        </div>
                                        <div class="mb-3 col-sm-12 text-center margin-auto">
                                            <button class="btn btn-primary light" type="submit">Search</button>
                                            <a href="{{ route('bookings') }}" class="btn btn-danger light" type="button">Reset</a>
                                        </div>
                                    
                                    </div>
                                </form>
                            
                                
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                                <th class="text-center text-secondary"><strong>Sl No.</strong></th>
                                                <th class="text-secondary"><strong>Hotel Name</strong></th>
                                                <th class="text-secondary"><strong>Master User</strong></th>
                                                <th class="text-center text-secondary"><strong>Room Number</strong></th>
                                                <th class="text-center text-secondary"><strong>Access-In</strong></th>
                                                <th class="text-center text-secondary"><strong>Access-Out</strong></th>
                                                <th class="text-secondary"><strong>Additional Users</strong></th>
                                                <th class="text-secondary"><strong>Additional Facilities</strong></th>
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
                                                                    <li><i class="fa fa-caret-right text-black"></i> {{ $adUser->user->name ?? '' }}</li>
                                                                @endforeach
                                                                </ul>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(isset($book->booking_facilities[0]))
                                                                <ul class="list-icons">
                                                                @foreach($book->booking_facilities as $adFac)
                                                                    <li><i class="fa fa-caret-right text-black"></i> {{ $adFac->facilities->facility_name ?? '' }}</li>
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
                                    <div class="pagination">
                                        {{ $bookings->appends(request()->input())->links() }}
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
        minimumInputLength: 3,
        width: 'inherit',
        placeholder: 'Select a user by Name/Email/Profile ID',
        ajax: {
            url: '{{ route("ajax-users") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
            return {
                results:  $.map(data, function (item) {
                    return {
                        text: item.name+' - '+item.profile_id+' ('+item.email+')',
                        id: item.id
                    }
                })
            };
            },
            cache: true
        }
    });
    $('#user').append('{!! $userOptions !!}').trigger('change');

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