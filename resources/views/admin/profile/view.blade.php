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
                                    <h3 class="card-title main-head">My Profile</h3>
                                </div>

                            </div>
							 <div class="card-body">
                              
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="profile card card-body px-3 pt-3 pb-0">
                                            <div class="profile-head">
                                                <div class="photo-content">
                                                    <div class="cover-photo rounded" style="background: url('{{asset($details->user_details->banner_image)}}');    background-size: 100% 100%;"></div>
                                                </div>
                                                <div class="profile-info">
                                                    <div class="profile-photo">
                                                        <img src="{{ asset($details->user_details->profile_image) }}" class="img-fluid rounded-circle" alt="">
                                                    </div>
                                                    <div class="profile-details">
                                                        <div class="profile-name px-3 pt-2">
                                                            <h3 class="text-primary mb-0">{{ $details->name }}</h3>
                                                            <h6>{{ $details->user_details->location }}</h6>
                                                            <h6>Email : {{ $details->email }}</h6>
                                                            <h6>Phone : {{ $details->user_details->phone_number }} 
                                                                 @if($details->user_details->phone1 != '' ) , {{ $details->user_details->phone1}} @endif </h6>
                                                        </div>
                                                        <!-- <div class="profile-email px-2 pt-2">
                                                            <h4 class="text-muted mb-0">{{ $details->email }}</h4>
                                                            <p>Email</p>
                                                        </div>

                                                        <div class="profile-email px-2 pt-2">
                                                            <h4 class="text-muted mb-0">{{ $details->user_details->phone_number }} , {{ $details->user_details->phone1 }}</h4>
                                                            <p>Phone</p>
                                                        </div> -->

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

		</div>
	</div>
</div>

			
		
@endsection
@section('header')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-material-datetimepicker.css') }}">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
<style>
.img-fluid {
    max-width: 300px !important;
    height: 150px !important;
}
.profile .profile-photo {
    max-width: 10rem !important;
    margin-top: 0rem !important;
}
p {
    margin-top: 0;
    margin-bottom: 0.5rem;
}
.photo-content .cover-photo {
    min-height: 20rem;
}
</style>
@endsection

@section('footer')
<script src="{{ asset('assets/js/bootstrap-material-datetimepicker.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script type="text/javascript">
    
   
</script>
@endsection