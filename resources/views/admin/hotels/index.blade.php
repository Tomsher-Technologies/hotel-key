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
                                    <h3 class="card-title main-head">All Hotels</h3>
                                </div>
                                <a href="{{ route('add-hotel') }}" class="btn btn-primary">Add New Hotel</a>
                            </div>
							 <div class="card-body">
                                <form  action="" method="GET">
                                    <div class="input-group mb-3 w-50">
                                        <input type="text" class="form-control" value="{{ $search_term }}" id="search_term" name="search_term"
                                        placeholder="Search with Hotel Name or Location or Email or Phone Number"  autocomplete="off">
                                        <button class="btn btn-primary light" type="submit">Search</button>
                                        <a href="{{ route('all-hotels') }}" class="btn btn-danger light" type="button">Reset</a>
                                    </div>
                                </form>
                             @include('flash::message')
                                <div class="table-responsive">
                                    
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th><strong class="black">Sl No.</strong></th>
                                                <th><strong class="black">Hotel Name</strong></th>
                                                <th><strong class="black">Banner Image</strong></th>
                                                <th><strong class="black">Location</strong></th>
                                                <th><strong class="black">Email</strong></th>
                                                <th><strong class="black">Phone Number</strong></th>
                                                <th><strong class="black">Status</strong></th>
                                                <th><strong class="black">Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($hotels[0]))
                                                @foreach($hotels as $key => $hot)
                                                <tr>
                                                    <td>
                                                    {{ $key + 1 + ($hotels->currentPage() - 1) * $hotels->perPage() }}
                                                    </td>
                                                    <td><strong>{{ $hot->name }}</strong></td>
                                                    <td>
                                                        @if($hot->user_details->banner_image != '')
                                                        <img class="rounded-square" width="100" src="{{ asset($hot->user_details->banner_image) }}" alt="">
                                                        @else

                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $hot->user_details->location }}
                                                    </td>
                                                    <td>{{ $hot->email }}	</td>
                                                    <td>{{ $hot->user_details->phone_number }}</td>
                                                    <td>
                                                        @if($hot->is_active == 1)
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
                                                            <a href="{{ route('edit-hotel',['id'=>$hot->id]) }}" class="btn btn-primary light shadow btn-xs sharp me-1 "><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp deleteHotel"  data-id="{{$hot->id}}" title="Delete Hotel"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No data found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $hotels->appends(request()->input())->links() }}
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
    $(document).on('click','.deleteHotel',function(){
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
                    url: "{{ route('hotel.delete') }}",
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