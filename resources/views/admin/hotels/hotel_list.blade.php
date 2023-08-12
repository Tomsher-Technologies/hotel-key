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
                               
                            </div>
							 <div class="card-body">
                                <div class="row">
                                    @if($hotels)
                                        @foreach($hotels as $hote)
                                            <div class="card col-lg-4" >
                                                <img class="card-img-top img-fluid" src="{{ asset($hote->user_details->banner_image ?? '') }}" alt="Card image cap">
                                                <div class="card-header">
                                                    <h5 class="card-title">{{ $hote->name }}</h5>
                                                    
                                                </div>
                                                <div class="card-body">
                                                    <p class="card-text">He lay on his armour-like back, and if he lifted his head a little
                                                    </p>
                                                </div>
                                                <div class="card-footer">
                                                    <p class="card-text d-inline">Card footer</p>
                                                    <a href="javascript:void(0);" class="card-link float-end">Card link</a>
                                                </div>
                                            </div> 
                                        @endforeach
                                    @endif
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