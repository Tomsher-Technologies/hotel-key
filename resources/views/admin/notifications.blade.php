@extends('admin.layouts.app')
@section('title', 'Notifications')
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
                                    <h3 class="card-title main-head">All Notifications</h3>
                                </div>
                              
                            </div>
							 <div class="card-body">
                             <form  action="" method="GET">
                                    <div class="row search-section">
                                        
                                        <div class="mb-3 col-sm-4">
                                            <label class="form-label">Notification Date</label>
                                            <input type="text" class="form-control" value="{{ $date_search }}" id="date_search" name="date_search"
                                            placeholder="YYYY-MM-DD" autocomplete="off">
                                        </div>

                                        <div class="mb-3 col-sm-3 margin-auto">
                                            <button class="btn btn-primary light" type="submit">Search</button>
                                            <a href="{{ route('notifications') }}" class="btn btn-danger light" type="button">Reset</a>
                                        </div>
                                    
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th><strong class="black">Sl No.</strong></th>
                                                <th><strong class="black">Notification</strong></th>
                                                <th class="text-center"><strong class="black">Date</strong></th>
                                                <th class="text-center w-20"><strong class="black">Acknowledgement Status</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($notifications[0]))
                                                @foreach($notifications as $key => $not)
                                                <tr>
                                                    <td>
                                                    {{ $key + 1 + ($notifications->currentPage() - 1) * $notifications->perPage() }}
                                                    </td>
                                                    <td><strong>{{ $not->content }}</strong></td>
                                                    
                                                    <td class="text-center">
                                                        {{ date('Y-m-d H:i a', strtotime($not->created_at)) }}
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        @if($not->is_read == 0 && $not->attended_by == null)
                                                            <a href="#" class="btn btn-primary shadow btn-xs acknowledged"  data-id="{{$not->id}}" ></i>Acknowledged</a>
                                                        @else
                                                            <span class="bold fw-6">By {{ $not->attendedBy->name }} </span><br>
                                                            {{ date('Y-m-d H:i a', strtotime($not->attended_at)) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">No data found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $notifications->appends(request()->input())->links() }}
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
@endsection

@section('footer')
<script src="{{ asset('assets/js/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">
    $('#date_search').bootstrapMaterialDatePicker({
        weekStart: 0,
        time: false,
        clearButton: true
    });
    $(document).on('click','.acknowledged',function(){
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Are you sure?", 
            text: "", 
            icon: "warning", 
            showCancelButton: !0, 
            confirmButtonColor: "#DD6B55", 
            confirmButtonText: "Yes !!", 
            cancelButtonText: "No, cancel it !!", 
        }).then(function(result){
            console.log(result);
            if(result.value){
                $.ajax({
                    url: "{{ route('notification.acknowledged') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token:'{{ @csrf_token() }}',
                    },
                    dataType: "html",
                    success: function () {
                        window.location.reload();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error!", "Please try again", "error");
                    }
                });
            }
        })
    }) ;
    
    $(document).on('click','#addFacility', function(){
        $('#addFacilityForm')[0].reset();
    });

    $(document).on('click','.editFacility', function(){
        $('#addFacilityForm')[0].reset();

        var id = $(this).attr('data-id');
        var fac = $(this).attr('data-fac');
        var status = $(this).attr('data-status');

        $('#facility_id').val(id);
        $('#facility').val(fac);
        
        $("#is_active option[value="+status+"]").attr('selected', 'selected');
        $('#addFacilityModal').modal('show');
    });

    $(document).on('click','#saveFacility', function(){
        $('#error').css('display','none');
        var facility = $('#facility').val();
        var flag= 1;
        if(facility == ''){
            flag = 0;
            $('#error').css('display','block');
        }
        if(flag == 1){
            $.ajax({
                url: "{{ route('add-facility') }}",
                type: "POST",
                data: {
                    facility: facility,
                    status : $('#is_active').val(),
                    id : $('#facility_id').val(),
                    _token:'{{ @csrf_token() }}',
                },
                dataType: "html",
                success: function (resp) {
                    if(resp != ''){
                        Swal.fire("Done!", "Succesfully saved!", "success");
                        $('#addFacilityForm')[0].reset();
                        setTimeout(function () { 
                            $('#addFacility').modal('hide');
                            window.location.reload();
                        }, 2000);
                    }else{
                        Swal.fire("Failed!", "Something went wrong!", "error");
                    }
                }
            });
        }
    });
</script>
@endsection