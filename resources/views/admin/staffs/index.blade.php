@extends('admin.layouts.app')
@section('title', 'All Staffs')
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
                                    <h3 class="card-title main-head">All Staffs</h3>
                                </div>
                                <a href="{{ route('add-staff') }}" class="btn btn-primary">Add New Staff</a>
                            </div>
							 <div class="card-body">
                                <form  action="" method="GET">
                                    <div class="input-group mb-3 w-50">
                                        <input type="text" class="form-control" value="{{ $search_term }}" id="search_term" name="search_term"
                                        placeholder="Search with Name or Email or Phone Number" autocomplete="off">
                                        <button class="btn btn-primary light" type="submit">Search</button>
                                        <a href="{{ route('all-staffs') }}" class="btn btn-danger light" type="button">Reset</a>
                                    </div>
                                </form>
                             @include('flash::message')
                                <div class="table-responsive">
                                    
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                                <th class="text-center"><strong class="black">Sl No.</strong></th>
                                                <th><strong class="black">Name</strong></th>
                                                <th><strong class="black">Email</strong></th>
                                                <th class="text-center"><strong class="black">Image</strong></th>
                                                
                                                <th class="text-center"><strong class="black">Phone Number</strong></th>
                                                <th class="text-center"><strong class="black">Status</strong></th>
                                                <th class="text-center"><strong class="black">Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($staffs[0]))
                                                @foreach($staffs as $key => $staff)
                                                <tr>
                                                    <td class="text-center">
                                                    {{ $key + 1 + ($staffs->currentPage() - 1) * $staffs->perPage() }}
                                                    </td>
                                                    <td><strong>{{ $staff->user_details->first_name }} {{ $staff->user_details->last_name }}</strong></td>
                                                    
                                                    <td>{{ $staff->email }}	</td>
                                                    <td class="text-center">
                                                        @if($staff->user_details->profile_image != '')
                                                        <img class="rounded-circle" width="35" height="35" src="{{ asset($staff->user_details->profile_image) }}" alt="">
                                                        @else

                                                        @endif
                                                    </td>
                                                    
                                                    <td class="text-center">{{ $staff->user_details->phone_number }}</td>
                                                    <td class="text-center">
                                                        @if($staff->is_active == 1)
                                                            <div class=" align-items-center">
                                                                <i class="fa fa-circle text-success me-1"></i>
                                                                Active
                                                            </div>
                                                        @else
                                                            <div class="align-items-center">
                                                                <i class="fa fa-circle text-danger me-1"></i>
                                                                In-Active
                                                            </div>
                                                        @endif
                                                        
                                                    </td>
                                                    
                                                    <td class="text-center">
                                                        <div class="">
                                                            <a href="{{ route('edit-staff',['id'=>$staff->id]) }}" class="btn btn-primary light shadow btn-xs sharp me-1 "  title="Edit Staff"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp deleteStaff"  data-id="{{$staff->id}}" title="Delete Staff"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="8" class="text-center">No data found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $staffs->appends(request()->input())->links() }}
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

@endsection

@section('footer')
<script type="text/javascript">
    $(document).on('click','.deleteStaff',function(){
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
                    url: "{{ route('staff.delete') }}",
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