@extends('admin.layouts.app')
@section('title', 'Support')
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
                                    <h3 class="card-title main-head">Support</h3>
                                </div>
                                @if( Auth::user()->user_type != 'admin' )
                                    <button type="button" class="btn btn-primary light mb-2" data-bs-toggle="modal" data-bs-target="#addSupportModal" id="addSupport">Add New</button>
                                @endif
                            </div>
							 <div class="card-body">
                             @include('flash::message')
                                <div class="table-responsive">
                                    
                                    <table class="table table-responsive-md table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="w-7 text-center"><strong class="black">Sl No.</strong></th>
                                                <th class="w-40"><strong class="black">Message</strong></th>
                                                <th class="w-40"><strong class="black">Reply</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($supports[0]))
                                                @foreach($supports as $key => $sup)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $key + 1 + ($supports->currentPage() - 1) * $supports->perPage() }}
                                                    </td>
                                                    <td>
                                                        <p style="margin-bottom: 0rem;"> {{ $sup->message }}</p> 
                                                      
                                                        <div class="w-100 text-end">
                                                            <span class="fw-500 text-danger">{{ date('Y-m-d H:i a', strtotime($sup->created_at)) }} </span>
                                                        </div>
                                                    </td>
                                                   
                                                    <td>
                                                        @if( Auth::user()->user_type == 'admin' && $sup->reply == null)
                                                            <a href="#" class="btn btn-primary shadow btn-xs supportReply"  data-id="{{$sup->id}}" data-msg="{{$sup->message}}"></i>Reply</a>
                                                        @endif
                                                        @if($sup->reply != null)
                                                            <p style="margin-bottom: 0rem;"><strong>{{ $sup->reply }}</strong></p> 
                                                            <div class="w-100 text-end">
                                                                @if(Auth::user()->user_type != 'admin' && $sup->is_read == 0)
                                                                    <span class="badge rounded-pill bg-success">New</span>
                                                                @endif
                                                                <span class="fw-500 text-danger">{{ date('Y-m-d H:i a', strtotime($sup->reply_at)) }} </span>
                                                            </div>
                                                        @endif
                                                    </td>
                                        
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center">No data found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="pagination">
                                        {{ $supports->appends(request()->input())->links() }}
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
    <div class="modal fade" id="addSupportModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Message</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form class="form-horizontal repeater" action="{{ route('add-support') }}" id="addSupportForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="mb-3 row">
                                        <label class="col-form-label cust-label" for="validationCustom01">Message
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" rows="8" id="message" name="message"  placeholder="Enter message"></textarea>
                                        <span class="text-danger " id="error" style="display:none;">This field is required</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary light" id="saveSupport">Save</button>
                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        
                    </div>
                   
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addSupportReplyModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Reply Message</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <form class="form-horizontal repeater" action="{{ route('update-support') }}" id="addSupportReplyForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        
                            <div class="row">
                                <div class="col-xl-12">
                                    <h5 >Message </h5>
                                    <p id="support_message"> </p>
                                    <input type="hidden" id="support_id" name="support_id" value="">
                                </div>

                                <div class="col-xl-12">
                                    <div class="mb-3 row">
                                        <label class="col-form-label cust-label" for="validationCustom01">Reply
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" rows="8" id="reply" name="reply"  placeholder="Enter reply message"></textarea>
                                        <span class="text-danger " id="error-reply" style="display:none;">This field is required</span>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-primary light" id="saveSupportReply">Save</button>
                                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        
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
    
    $(document).on('click','#addSupport', function(){
        $('#addSupportForm')[0].reset();
        $('#error').css('display','none');
    });

    $(document).on('click','.supportReply', function(){
        $('#addSupportReplyForm')[0].reset();
        $('#error-reply').css('display','none');
        var id = $(this).attr('data-id');
        var msg = $(this).attr('data-msg');
        $('#support_message').html(msg);
        $('#support_id').val(id);
        $('#addSupportReplyModal').modal('show');
    });

    $(document).on('click','#saveSupportReply', function(){
        $('#error-reply').css('display','none');
        var reply = $.trim($('#reply').val());
        var id = $('#support_id').val();
        var flagR= 1;
        
        if(reply == ''){
            flagR = 0;
            $('#error-reply').css('display','block');
        }
        if(flagR == 1){
            $.ajax({
                url: "{{ route('update-support') }}",
                type: "POST",
                data: {
                    reply: reply,
                    id: id,
                    _token:'{{ @csrf_token() }}',
                },
                dataType: "html",
                success: function (resp) {
                    if(resp != ''){
                        Swal.fire("Done!", "Succesfully Saved!", "success");
                        $('#addSupportReplyForm')[0].reset();
                        setTimeout(function () { 
                            $('#addSupportReplyModal').modal('hide');
                            window.location.reload();
                        }, 2000);
                    }else{
                        Swal.fire("Failed!", "Something went wrong!", "error");
                    }
                }
            });
        }
    });

   
    $(document).on('click','#saveSupport', function(){
        $('#error').css('display','none');
        var message = $.trim($('#message').val());
        var flag= 1;
        
        if(message == ''){
            flag = 0;
            $('#error').css('display','block');
        }
        if(flag == 1){
            $.ajax({
                url: "{{ route('add-support') }}",
                type: "POST",
                data: {
                    message: message,
                    _token:'{{ @csrf_token() }}',
                },
                dataType: "html",
                success: function (resp) {
                    if(resp != ''){
                        Swal.fire("Done!", "Succesfully Send!", "success");
                        $('#addSupportForm')[0].reset();
                        setTimeout(function () { 
                            $('#addSupportModal').modal('hide');
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