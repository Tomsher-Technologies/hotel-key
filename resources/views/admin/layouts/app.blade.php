
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="noindex" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:image" content="">
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>{{ env('APP_NAME') }} - @yield('title')</title>
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin-css.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    @yield('header')
    
</head>
<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div class="dz-ripple">
			<div></div>
			<div></div>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
		@include('admin.includes.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
		@include('admin.includes.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="outer-body">
			<div class="inner-body">
		        @yield('content')
                @include('admin.includes.footer')
            </div>
		</div>
		
        <!--**********************************
            Content body end
        ***********************************-->
	</div>
    @yield('modal')
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('assets/js/global.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/deznav-init.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
	<script>
        $('div.alert').not('.alert-important').delay(5000).fadeOut(350);
		$(document).ready(function(){
            // $(".nav-item .open-cal").click(function(){
            // 	$(".calendar-warpper").toggleClass("active");
            //   });

           
		});
        window.setInterval(function(){
            checkNotification()
        }, 30000);

        function checkNotification(){
            $.ajax({
                    url: "{{ route('notification.check') }}",
                    type: "GET",
                    dataType: "html",
                    success: function (resp) {
                        var response = JSON.parse(resp);
                        if(response.length != 0 && response.count != 0){
                            $('.not-badge').html(response.count);
                            $('.not-badge').css('display','block');
                            Swal.fire({
                                title: "<span style='color:red;'>Alert!</span>",
                                icon: '',
                                position: 'bottom-end',
                                showConfirmButton: false,
                                showCloseButton: true,
                                html:  "<h3 style='color:red;'>"+response.msg+"</h3>",
                               
                            });
                        }else{
                            $('.not-badge').css('display','none');
                        }
                    
                    }
                });
        }
	</script>
	@yield('footer')
	
</body>
</html>