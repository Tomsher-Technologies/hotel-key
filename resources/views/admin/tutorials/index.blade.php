@extends('admin.layouts.app')
@section('title', 'Tutorials')
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
                                    <h3 class="card-title main-head">All Tutorials</h3>
                                </div>
                                <a href="{{ route('add-tutorial') }}" class="btn btn-primary">Add New Tutorial</a>
                            </div>
							 <div class="card-body">
                               
                             @include('flash::message')
                                <div class="table-responsive">
                                    
                                    <table class="table table-responsive-md">
                                        <thead>
                                        <tr>
                                                <th class="text-center w-10"><strong class="black">Sl No.</strong></th>
                                                <th><strong class="black">Title</strong></th>
                                                <th><strong class="black">Link</strong></th>
                                                <th class="text-center w-20"><strong class="black">Image</strong></th>
                                                <th class="text-center w-10"><strong class="black">Action</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($tutorials[0]))
                                                @foreach($tutorials as $key => $tut)
                                                <tr>
                                                    <td class="text-center">
                                                    {{ $key + 1 + ($tutorials->currentPage() - 1) * $tutorials->perPage() }}
                                                    </td>
                                                    <td><strong>{{ $tut->title }}</strong></td>
                                                    
                                                    <td>{{ $tut->link }}	</td>
                                                    <td class="text-center">
                                                        @if($tut->image != '')
                                                        <img class="rounded-circle" width="100" height="80" src="{{ asset($tut->image) }}" alt="">
                                                        @else

                                                        @endif
                                                    </td>
                                                    
                                                    
                                                    <td class="text-center">
                                                        <div class="">
                                                            <a href="{{ route('edit-tutorial',['id'=>$tut->id]) }}" class="btn btn-primary light shadow btn-xs sharp me-1 "  title="Edit Tutorial"><i class="fa fa-pencil"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp deleteTutorial"  data-id="{{$tut->id}}" title="Delete Tutorial"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">No data found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $tutorials->appends(request()->input())->links() }}
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
    $(document).on('click','.deleteTutorial',function(){
        var id = $(this).attr('data-id');
        Swal.fire({
            title: "Are you sure to delete ?", 
            text: "", 
            icon: "warning", 
            showCancelButton: !0, 
            confirmButtonColor: "#DD6B55", 
            confirmButtonText: "Yes, delete it !!", 
            cancelButtonText: "No, cancel it !!", 
        }).then(function(result){
            console.log(result);
            if(result.value){
                $.ajax({
                    url: "{{ route('tutorial.delete') }}",
                    type: "POST",
                    data: {
                        id: id,
                        _token:'{{ @csrf_token() }}',
                    },
                    dataType: "html",
                    success: function () {
                        Swal.fire("Done!", "Succesfully deleted!", "success");
                        setTimeout(function () { 
                            window.location.reload();
                        }, 3000);  
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        })
    }) ;
</script>
@endsection