@extends('admin.layouts.app')

@section('content')

<div class="content-body">
	<div class="container-fluid">
		<h3 class="head-title">Dashboard</h3>
		<div class="row">
			<div class="col-xl-12 box-warpper">
				<div class="row">
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-4 mb-3">
								<div class="example">
									<p class="mb-1">Date Range Filter</p>
									<input class="form-control input-daterange-datepicker" type="text" name="date_range" id="date_range" placeholder="DD/MM/YYYY - DD/MM/YYYY">
								</div>
							</div>
							@if(Auth::user()->user_type == 'admin')
								<div class="col-xl-4 mb-3">
									<div class="example">
										<p class="mb-1">Hotel Filter</p>
										<select class="me-sm-2 select2 select2-hidden-accessible form-control wide" style="width:100% !important;" name="hotel" id="hotel">
											<option value=""> Select Hotel </option>
											@foreach($hotels as $hote)
												<option value="{{ $hote['id'] }}">{{ $hote['name'] }}</option>
											@endforeach
										</select>
									</div>
								</div>
							@else
								<input type="hidden" name="hotel" id= "hotel" value="">
							@endif
							<div class="col-xl-3 mb-3 margin-auto">
								<button type="button" class="btn btn-primary light">Reset Filter</button>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-3">
								<div class="card bg-primary-light">
									<div class="card-body depostit-card">
										<div class="depostit-card-media d-flex justify-content-between">
											<div>
												@if(Auth::user()->user_type == 'admin')
												<h6 class="font-w400 mb-0">Hotel <br>Check-In</h6>
												@else
												<h6 class="font-w400 mb-0">Check-In</h6>
												@endif
												<h3 id="checkins"></h3>
											</div>
											<div class="icon-box">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_71_124)">
													<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z" fill="#252525"/>
													</g>
													<defs>
													<clipPath id="clip0_71_124">
													<rect width="24" height="24" fill="white"/>
													</clipPath>
													</defs>
												</svg>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-sm-3">
								<div class="card bg-warning-light diposit-bg">
									<div class="card-body depostit-card">
										<div class="depostit-card-media d-flex justify-content-between">
											<div>
												@if(Auth::user()->user_type == 'admin')
												<h6 class="font-w400 mb-0">Hotel <br> Check-Out</h6>
												@else
												<h6 class="font-w400 mb-0">Check-Out</h6>
												@endif
												
												<h3 id="checkouts"></h3>
											</div>
											<div class="icon-box">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_71_124)">
													<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z" fill="#252525"/>
													</g>
													<defs>
													<clipPath id="clip0_71_124">
													<rect width="24" height="24" fill="white"/>
													</clipPath>
													</defs>
												</svg>
											</div>
										</div>
									</div>
								</div>
							</div>
							@if(Auth::user()->user_type == 'admin')
							<div class="col-sm-3">
								<div class="card bg-danger-light diposit-bg">
									<div class="card-body depostit-card">
										<div class="depostit-card-media d-flex justify-content-between">
											<div>
												<h6 class="font-w400 mb-0"> Users</h6>
												<h3 id="users"></h3>
											</div>
											<div class="icon-box">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_71_124)">
													<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z" fill="#252525"/>
													</g>
													<defs>
													<clipPath id="clip0_71_124">
													<rect width="24" height="24" fill="white"/>
													</clipPath>
													</defs>
												</svg>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endif

							<!-- 

							<div class="col-sm-3">
								<div class="card bg-info-light diposit-bg">
									<div class="card-body depostit-card">
										<div class="depostit-card-media d-flex justify-content-between">
											<div>
												<h6 class="font-w400 mb-0">Tasks Not Finisheds</h6>
												<h3>20</h3>
											</div>
											<div class="icon-box">
												<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
													<g clip-path="url(#clip0_71_124)">
													<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z" fill="#252525"/>
													<path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z" fill="#252525"/>
													</g>
													<defs>
													<clipPath id="clip0_71_124">
													<rect width="24" height="24" fill="white"/>
													</clipPath>
													</defs>
												</svg>
											</div>
										</div>
									</div>
								</div>
							</div> -->
							
						</div>
					</div>
					<!-- <div class="col-xl-12">
						<div class="card overflow-hidden">
							<div class="card-header border-0 pb-0 flex-wrap">
								<h4 class="card-title mb-0">Projects Overview</h4>
								<ul class="nav nav-pills mix-chart-tab" id="pills-tab" role="tablist">
									<li class="nav-item" role="presentation">
									<button class="nav-link active" data-series="week" id="pills-week-tab" data-bs-toggle="pill" data-bs-target="#pills-week" type="button" role="tab"  aria-selected="true">Week</button>
									</li>
									<li class="nav-item" role="presentation">
									<button class="nav-link" data-series="month" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab"  aria-selected="false">Month</button>
									</li>
									<li class="nav-item" role="presentation">
									<button class="nav-link" data-series="year" id="pills-year-tab" data-bs-toggle="pill" data-bs-target="#pills-year" type="button" role="tab"  aria-selected="false">Year</button>
									</li>
									<li class="nav-item" role="presentation">
									<button class="nav-link" data-series="all" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-selected="false">All</button>
									</li>
								</ul>
							</div>
							<div class="card-body custome-tooltip p-0">
								<div id="overiewChart"></div>
							</div>
						</div>
					</div> -->
					
				</div>
			</div>
			@include('admin.includes.calendar')
		</div>
	</div>
</div>

			
		
@endsection
@section('header')
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endsection

@section('footer')
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script type="text/javascript">
	 $('.select2').select2({
        'placeholder':'Select'
    });

	var today = getToday();

	function getToday() {
		var d = new Date();

		var month = d.getMonth() + 1;
		var day = d.getDate();

		var output = d.getFullYear() + '-' +
			(('' + month).length < 2 ? '0' : '') + month + '-' +
			(('' + day).length < 2 ? '0' : '') + day;

		return output;
	}

	$('.input-daterange-datepicker').daterangepicker({
		locale: {
            format: 'MMM D, Y'
        },
		ranges: {
            'Past 24 Hours': [moment().subtract(1, 'days'), moment()],
            'Today': [moment().startOf('day'), moment().endOf('day')],
            'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                'month')],
        },
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });

	$('input[name="date_range"]').on('apply.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate.format('YYYY-MM-DD');
        var endDate = picker.endDate.format('YYYY-MM-DD');
		var hotel = $('#hotel').val();
		
        getCounts(startDate, endDate, hotel);
    });

	$(document).on('change','#hotel',function(){
		var hotel = $(this).val();
        var dateRange = $('#date_range').val();
		var startDate = getDateYMD(dateRange.split(' - ')[0]);  
		var endDate = getDateYMD(dateRange.split(' - ')[1]);
        getCounts(startDate, endDate, hotel);
    })

	function getDateYMD(strDate) {
		var date = new Date(strDate)
		yr = date.getFullYear(),
		month = date.getMonth()+1,
		day = date.getDate(),
		newDate = yr + '-' + month + '-' + day;
		return newDate;
	}

	getCounts(today, today, '');

	function getCounts(startDate, endDate, hotel) {
        $.ajax({
            url: "{{ route('dashboard-counts')}}",
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
                "start": startDate,
                "end": endDate,
				"hotel":hotel
            },
            success: function(response) {
                var resp = JSON.parse(response);

                $('#checkins').html(resp.data.checkin);
				$('#checkouts').html(resp.data.checkout);
                $('#users').html(resp.data.users);
               
            }
        });
    }
</script>
@endsection