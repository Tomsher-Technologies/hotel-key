@extends('admin.layouts.app')
@section('title', 'Update Access')
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
                                    <h3 class="card-title main-head">Update Access</h3>
                                </div>
                                <a href="{{ route('all-bookings') }}" class="btn btn-primary">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-horizontal" id="hotelBooking" action="{{ route('update-booking', $booking->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <div class="row">
                                            <div class="col-xl-8">

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="main_user">Master User
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                    @php
                                                        $mUser = array($booking->main_user_id);
                                                        $mainUser = getUserDetails($mUser);
                                                        $userOptions = '<option value="'. $mainUser[0]->id .'" selected>'.$mainUser[0]->name.'-'.$mainUser[0]->profile_id.' ('.$mainUser[0]->email.')</option>';
                                                    @endphp
                                                        <select class="me-sm-2 form-control wide" style="width:100% !important;" name="main_user"  id="main_user">
                                                            
                                                        </select>
                                                        @error('main_user')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                @php   
                                                    $addUsers = $additionUsers = [];
                                                    if(isset($booking->additional_users_without_main_user[0])){
                                                        $additionalUsers = $booking->additional_users_without_main_user;
                                                        foreach($additionalUsers as $add){
                                                            $addUsers[] = $add->user_id;
                                                        }
                                                    }
                                                   if(!empty($addUsers)){
                                                        $additionUsers = getUserDetails($addUsers);
                                                   }
                                                   $userAddOptions = '';
                                                @endphp
                                               
                                                @foreach($additionUsers as $user)
                                                    @php 
                                                        $userAddOptions .= '<option value="'. $user->id .'" selected>'.$user->name.'-'.$user->profile_id.' ('.$user->email.')</option>';
                                                    @endphp
                                                @endforeach
                                               
                                                <div class="mb-3 row">
                                                    <input type="hidden" name="oldUser" value="{{ json_encode($addUsers) }}">
                                                    <label class="col-lg-4 col-form-label" for="additional_users">Additional Users</label>
                                                    <div class="col-lg-8">
                                                        <select class="me-sm-2 form-control wide" style="width:100% !important;" name="additional_users[]" multiple id="additional_users">
                                                        
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="room_number">Room Number <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('room_number', $booking->room_number) }}" id="room_number" name="room_number" placeholder="Enter room number">
                                                        @error('room_number')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row form-material">
                                                    <label class="col-lg-4 col-form-label" for="check_in">Access-In<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control datetime" value="{{ old('check_in',$booking->checkin_date.' '.$booking->checkin_time) }}"  id="check_in" name="check_in" placeholder="YYYY-MM-DD HH:mm">
                                                        @error('check_in')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row form-material">
                                                    <label class="col-lg-4 col-form-label" for="check_out">Access-Out<span
                                                            class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control datetime" value="{{ old('check_out',$booking->checkout_date.' '.$booking->checkout_time) }}"  id="check_out" name="check_out" placeholder="YYYY-MM-DD HH:mm">
                                                        @error('check_out')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @php
                                                    $addFac = [];
                                                    if(isset($booking->booking_facilities[0])){
                                                        $additionalFac = $booking->booking_facilities;
                                                        foreach($additionalFac as $addF){
                                                            $addFac[] = $addF->facility_id;
                                                        }
                                                    }
                                                @endphp
                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="facilities">Other Facilities</label>
                                                    <div class="col-lg-8">
                                                        <input type="hidden" name="oldfac" value="{{ json_encode($addFac) }}">
                                                        <select class="me-sm-2 select2 select2-hidden-accessible form-control wide" style="width:100% !important;" name="facilities[]" multiple id="facilities">
                                                            @foreach($facilities as $fac)
                                                                @php
                                                                    $selectFac = '';
                                                                    if(in_array($fac->id , $addFac)){
                                                                        $selectFac = 'selected';
                                                                    }
                                                                @endphp
                                                                <option value="{{ $fac->id }}" {{ $selectFac }}>{{ $fac->facility_name }}</option>
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
    .select2-selection--multiple{
        overflow: hidden !important;
        height: auto !important;
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
    $('#additional_users').select2({
        minimumInputLength: 3,
        width: 'inherit',
        placeholder: 'Select a user by Name/Email/Profile ID',
        multiple:true,
        ajax: {
            url: '{{ route("ajax-users") }}',
            dataType: 'json',
            delay: 250,
            data: function(params){
                return {
                    q: params.term,
                    main: $('#main_user').val()
                };
            },
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

    $('#main_user').select2({
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

    $('#main_user').append('{!! $userOptions !!}').trigger('change');
    $('#additional_users').append('{!! $userAddOptions !!}').trigger('change');
   
    $('#check_out').bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm'
    });

    $('#check_in').bootstrapMaterialDatePicker({
        weekStart: 0, format: 'YYYY-MM-DD HH:mm'
        // , minDate : new Date()
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