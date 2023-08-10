@extends('admin.layouts.app')

@section('content')

<div class="content-body">
	<div class="container-fluid">
		<!-- <h3 class="head-title">Dashboard</h3> -->
		<div class="row">
			<div class="col-xl-12">
				<div class="row">
					<div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <h3 class="card-title main-head">Add New Booking</h3>
                                </div>
                                <a href="{{ route('all-bookings') }}" class="btn btn-primary">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-horizontal" id="hotelBooking" action="{{ route('store-booking') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @php   $userOptions = '<option value="">Select User</option>'; @endphp
                                        @foreach($users as $user)
                                            @php 
                                                $userOptions .= '<option value="'. $user->id .'">'.$user->name.' ('.$user->email.')</option>';
                                            @endphp
                                        @endforeach
                                        <div class="row">
                                            <div class="col-xl-8">

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom01">Main User
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <select class="me-sm-2 select2 form-control wide" style="width:100% !important;" name="main_user"  id="main_user">
                                                            {!! $userOptions !!}
                                                        </select>
                                                        @error('main_user')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>


                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom01">Additional Users</label>
                                                    <div class="col-lg-8">
                                                        <select class="me-sm-2 select2 form-control wide" style="width:100% !important;" name="additional_users[]" multiple id="additional_users">
                                                        {!! $userOptions !!}
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Room Number <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('room_number') }}" id="room_number" name="room_number" placeholder="Enter room number">
                                                        @error('room_number')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row form-material">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Check-In<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control datetime" value="{{ old('check_in') }}"  id="check_in" name="check_in" placeholder="YYYY-MM-DD HH:mm">
                                                        @error('check_in')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row form-material">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Check-Out<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control datetime" value="{{ old('check_out') }}"  id="check_out" name="check_out" placeholder="YYYY-MM-DD HH:mm">
                                                        @error('check_out')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom01">Other Facilities</label>
                                                    <div class="col-lg-8">
                                                        <select class="me-sm-2 select2 select2-hidden-accessible form-control wide" style="width:100% !important;" name="facilities[]" multiple id="facilities">
                                                            @foreach($facilities as $fac)
                                                                <option value="{{ $fac->id }}">{{ $fac->facility_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('facilities')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-lg-8 ms-auto">
                                                        <button type="submit" class="btn btn-primary light">Save</button>
                                                        <a href="{{ route('all-bookings') }}" class="btn btn-danger light">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </form>
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
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-datetimepicker.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    .select2 {
        
    }
</style> 
@endsection

@section('footer')
<script src="{{ asset('assets/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    $('.select2').select2({
        'placeholder':'Select'
    });
   
    $('#check_out').bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm'
    });

    $('#check_in').bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm', minDate : new Date()
        // shortTime : true
    }).on('change', function(e, date) {
        $('#check_out').bootstrapMaterialDatePicker('setMinDate', date);
    });
    
    $("#hotelBooking").validate({
            rules: {
                main_user: {
                    required: true
                },
                room_number:{
                    required:true
                },
                check_in:{
                    required:true
                },
                check_out:{
                    required:true
                }
            },
            errorPlacement: function (error, element) {
                if(element.hasClass('select2')) {
                    error.insertAfter(element.next('.select2-container'));
                }else{
                    error.appendTo(element.parent("div"));
                }
            },
            submitHandler: function(form,event) {
                form.submit();
            }
        });
</script>
@endsection