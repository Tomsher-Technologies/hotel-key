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
                                    <h3 class="card-title main-head">Update Profile</h3>
                                </div>
                            </div>
                            <div class="card-body">
                            @include('flash::message')
                                <div class="form-validation">
                                    <form class="form-horizontal repeater" action="{{ route('save-profile') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-7">
                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom01">Hotel Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $hotel->name) }}" placeholder="Enter hotel name">
                                                        @error('name')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Email <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('email', $hotel->email) }}" id="email" name="email" placeholder="Enter email">
                                                        @error('email')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom04">Location <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <textarea class="form-control h-50" id="location" name="location"  rows="5" placeholder="Enter location" >{{ old('location', $hotel->user_details->location) }}</textarea>
                                                        @error('location')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Phone Number <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('phone_number', $hotel->user_details->phone_number) }}" id="phone_number" name="phone_number" placeholder="Enter phone number">
                                                        @error('phone_number')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Phone Number 2 (Optional) </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" value="{{ old('phone_number2',$hotel->user_details->phone1) }}" id="phone_number2" name="phone_number2" placeholder="Enter phone number">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Logo </label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" value="" id="logo" name="logo" >

                                                        @if($hotel->user_details->profile_image != NULL)
                                                            <img class="mt-3" src="{{ asset($hotel->user_details->profile_image) }}" style="width:250px" />
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-lg-4 col-form-label" for="validationCustom02">Banner Image</label>
                                                    <div class="col-lg-8">
                                                        <input type="file" class="form-control" value="" id="banner_image" name="banner_image" >

                                                        @if($hotel->user_details->banner_image != NULL)
                                                            <img class="mt-3" src="{{ asset($hotel->user_details->banner_image) }}" style="width:250px" />
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-lg-8 ms-auto">
                                                        <button type="submit" class="btn btn-primary light">Update</button>
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

@endsection

@section('footer')
<script type="text/javascript">

</script>
@endsection