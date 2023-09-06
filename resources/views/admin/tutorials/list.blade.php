@extends('admin.layouts.app')
@section('title', 'Tutorials')
@section('content')

<div class="content-body">
	<div class="container-fluid">
		<!-- <h3 class="head-title">Dashboard</h3> -->
		<div class="row">
			<div class="col-xl-12">
            <h3 class="card-title main-head">Tutorials</h3>
				<div class="row mt-3">
                    @if($tutorials)
                        @foreach($tutorials as $tut)
                            <div class="col-xl-3 col-md-3 col-6">
                                <div class="card  blog-card">
                                    <div class="card-body text-center">
                                        <a href="{{ $tut->link }}" target="_blank" title="{{$tut->title}}">
                                            @if($tut->image != null)
                                                <img src="{{ asset($tut->image) }}" width="200" height="100" alt=""> 
                                            @else
                                                <img src="{{ asset('assets/images/video-icon.png') }}" width="130" height="100" alt=""> 
                                            @endif
                                            <h5 >{{$tut->title}}</h5>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
				</div>
                <div class="pagination">
                    {{ $tutorials->appends(request()->input())->links() }}
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