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
                                    <h3 class="card-title main-head">All Access</h3>
                                </div>
                                <a href="{{ route('add-booking') }}" class="btn btn-primary">Add New Access</a>
                            </div>
							 <div class="card-body">
                             @include('flash::message')
                                <form  action="" method="GET">
                                    <div class="row search-section">
                                        <div class="mb-3 col-sm-5">
                                            <label class="form-label">User Name/Profile ID/Email/Room Number</label>
                                            <input type="text" class="form-control" value="{{ $search_term }}" id="search_term" name="search_term"
                                            placeholder="Search with User Name or Profile ID or Email or Room Number" autocomplete="off">
                                            
                                        </div>
                                        <div class="mb-3 col-sm-2">
                                            <label class="form-label">Access-In Date</label>
                                            <input type="text" class="form-control" value="{{ $checkin_search }}" id="checkin" name="checkin"
                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                        </div>
                                        <div class="mb-3 col-sm-2">
                                            <label class="form-label">Access-Out Date</label>
                                            <input type="text" class="form-control" value="{{ $checkout_search }}" id="checkout" name="checkout"
                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                        </div>
                                        <div class="mb-3 col-sm-3 margin-auto">
                                            <button class="btn btn-primary light" type="submit">Search</button>
                                            <a href="{{ route('all-bookings') }}" class="btn btn-danger light" type="button">Reset</a>
                                        </div>
                                    
                                    </div>
                                </form>
                            
                                
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                                <th class="text-center text-secondary"><strong>Sl No.</strong></th>
                                                <th class="text-secondary"><strong>Master User</strong></th>
                                                <th class="text-center text-secondary"><strong>Room Number</strong></th>
                                                <th class="text-center text-secondary"><strong>Access-In</strong></th>
                                                <th class="text-center text-secondary"><strong>Access-Out</strong></th>
                                                <th class="text-secondary"><strong>Additional Users</strong></th>
                                                <th class="text-secondary"><strong>Additional Facilities</strong></th>
                                                <th class="text-secondary"><strong>Action</strong></th>
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
                                                        
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="{{ route('edit-booking',['id'=>$book->id]) }}" class="btn btn-primary light shadow btn-xs sharp me-1" title="Edit Access"><i class="fa fa-pencil"></i></a>
                                                                <a href="#" class="btn btn-danger shadow btn-xs sharp deleteHotelBooking"  data-id="{{$book->id}}" title="Delete Access"><i class="fa fa-trash"></i></a>
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
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-datetimepicker.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('footer')
<script src="{{ asset('assets/js/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">
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
 $(document).on('click','.deleteHotelBooking',function(){
        var id = $(this).attr('data-id');
        swal({ 
            title: "Are you sure to delete ?", 
            text: "", 
            type: "warning", 
            showCancelButton: !0, 
            confirmButtonColor: "#DD6B55", 
            confirmButtonText: "Yes, delete it !!", 
            cancelButtonText: "No, cancel it !!", 
        }).then(function(result){
            console.log(result);
            if(result.value){
                $.ajax({
                    url: "{{ route('booking.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token:'{{ @csrf_token() }}',
                    },
                    dataType: "html",
                    success: function () {
                        swal.fire("Done!", "Succesfully deleted!", "success");
                        setTimeout(function () { 
                            window.location.reload();
                        }, 3000);  
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        })
    }) ;
</script>
@endsection