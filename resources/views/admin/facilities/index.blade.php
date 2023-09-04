@extends('admin.layouts.app')
@section('title', 'All Facilities')
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
                                    <h3 class="card-title main-head">All Facilities</h3>
                                </div>
                                <button type="button" class="btn btn-primary light mb-2" data-bs-toggle="modal" data-bs-target="#addFacilityModal" id="addFacility">Add New Facility</button>
                            </div>
							 <div class="card-body">
                             @include('flash::message')
                                <div class="table-responsive">
                                    
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th><strong class="black">Sl No.</strong></th>
                                                <th><strong class="black">Facility</strong></th>
                                                <th><strong class="black">Status</strong></th>
                                                <th><strong class="black">Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($facilities[0]))
                                                @foreach($facilities as $key => $fac)
                                                <tr>
                                                    <td>
                                                    {{ $key + 1 + ($facilities->currentPage() - 1) * $facilities->perPage() }}
                                                    </td>
                                                    <td><strong>{{ $fac->facility_name }}</strong></td>
                                                    
                                                    <td>
                                                        @if($fac->is_active == 1)
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-circle text-success me-1"></i>
                                                                Active
                                                            </div>
                                                        @else
                                                            <div class="d-flex align-items-center">
                                                                <i class="fa fa-circle text-danger me-1"></i>
                                                                In-Active
                                                            </div>
                                                        @endif
                                                        
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="#" class="btn btn-primary light shadow btn-xs sharp me-1 editFacility" data-id="{{$fac->id}}" data-fac="{{$fac->facility_name}}" data-status="{{$fac->is_active}}"  title="Edit Facility"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp deleteFacility"  data-id="{{$fac->id}}" title="Delete Facility"><i class="fa fa-trash"></i></a>
                                                        </div>
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
                                        {{ $facilities->appends(request()->input())->links() }}
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
@section('modal')
    <div class="modal fade" id="addFacilityModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Facility</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form class="form-horizontal repeater" action="{{ route('add-facility') }}" id="addFacilityForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="facility_id" id="facility_id" value="">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom01">Facility
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control" id="facility" name="facility" value="" placeholder="Enter hotel name">
                                            <span class="text-danger " id="error" style="display:none;">This field is required</span>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-lg-4 col-form-label" for="validationCustom02">Active Status <span
                                                class="text-danger">*</span>
                                        </label>
                                        <div class="col-lg-8">
                                            <select class="me-sm-2 form-control wide" name="is_active" id="is_active">
                                                <option value="1">Active</option>
                                                <option value="0">In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary light" id="saveFacility">Save</button>
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection			
		
@endsection
@section('header')

@endsection

@section('footer')
<script type="text/javascript">
    $(document).on('click','.deleteFacility',function(){
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
                    url: "{{ route('facility.delete') }}",
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
                        swal.fire("Done!", "Succesfully saved!", "success");
                        $('#addFacilityForm')[0].reset();
                        setTimeout(function () { 
                            $('#addFacility').modal('hide');
                            window.location.reload();
                        }, 2000);
                    }else{
                        swal.fire("Failed!", "Something went wrong!", "error");
                    }
                }
            });
        }
    });
</script>
@endsection