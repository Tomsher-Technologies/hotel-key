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
                                    <h3 class="card-title main-head">Update User</h3>
                                </div>
                                <a href="{{ route('all-users') }}" class="btn btn-primary">Back</a>
                            </div>
                            <div class="card-body">
                                <div class="form-validation">
                                    <form class="form-horizontal repeater" action="{{ route('user.update', $user->id) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom01">First Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->user_details->first_name) }}" placeholder="Enter first name">
                                                        @error('first_name')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom01">Last Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->user_details->last_name) }}" placeholder="Enter last name">
                                                        @error('last_name')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Email <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('email', $user->email) }}" id="email" name="email" placeholder="Enter email">
                                                        @error('email')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom03">Password</label>
                                                    <div class="col-lg-8">
                                                        <input type="password"autocomplete="new-password" class="form-control" value="{{ old('password') }}" id="password" name="password" placeholder="Enter password">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Phone Number <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('phone_number', $user->user_details->phone_number) }}" id="phone_number" name="phone_number" placeholder="Enter phone number">
                                                        @error('phone_number')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Gender</label>
                                                    <div class="col-lg-8">
                                                        <select class="me-sm-2 default-select form-control wide" name="gender" id="gender">
                                                            <option value="">Select gender</option>
                                                            <option {{ (old('gender', $user->user_details->gender) == 'male') ? 'selected' : '' }} value="male" >Male</option>
                                                            <option {{ (old('gender', $user->user_details->gender) == 'female') ? 'selected' : '' }} value="female" >Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3 row form-material">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Date Of Birth</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('dob', $user->user_details->date_of_birth) }}"  id="dob" name="dob" placeholder="YYYY-MM-DD">
                                                       
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Profile Image </label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" id="profile_image" name="profile_image" >
                                                        @if($user->user_details->profile_image != NULL)
                                                            <img class="mt-3" src="{{ asset($user->user_details->profile_image) }}" style="width:250px" />
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Active Status <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <select class="me-sm-2 default-select form-control wide" name="is_active" id="is_active">
                                                            <option {{ ($user->is_active == 1) ? 'selected' : '' }} value="1">Active</option>
                                                            <option {{ ($user->is_active == 0) ? 'selected' : '' }} value="0">In-Active</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-lg-8 ms-auto">
                                                        <button type="submit" class="btn btn-primary light">Save</button>
                                                        <a href="{{ route('all-users') }}" class="btn btn-danger light">Cancel</a>
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
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-datetimepicker.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection

@section('footer')
<script src="{{ asset('assets/js/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">
   $('#dob').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false
    });
</script>
@endsection