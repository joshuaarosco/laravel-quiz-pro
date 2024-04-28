@extends('backoffice._layout.main')

@push('title','Dashboard')

@push('included-styles')
<link href="{{asset('assets/plugins/nvd3/nv.d3.min.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('assets/plugins/mapplic/css/mapplic.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/rickshaw/rickshaw.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css')}}" rel="stylesheet" type="text/css" media="screen">
<link href="{{asset('assets/plugins/jquery-metrojs/MetroJs.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('assets/plugins/codrops-dialogFx/dialog.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('assets/plugins/codrops-dialogFx/dialog-sandra.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('assets/plugins/owl-carousel/assets/owl.carousel.css')}}" rel="stylesheet" type="text/css" media="screen" />
<link href="{{asset('assets/plugins/jquery-nouislider/jquery.nouislider.css')}}" rel="stylesheet" type="text/css" media="screen" />
<style>
	.widget-2:after {
		background-image: url("{{asset('web/assets/images/PSU_dashboard.jpg')}}")!important;
	}
	.widget-1:after {
		background-image: url("{{asset('web/assets/images/PSU_graduates.jpg')}}")!important;
	}
	.card.full-height {
		height: unset!important;
	}
	.full-height {
		height: unset!important;
	}
	.m-t-3{
		margin-top: 3px;
	}
</style>
@endpush

@push('content')
<div class="content sm-gutter">
	<div class="container-fluid padding-25 sm-padding-10">
		<div class="row">
			<div class="col-md-12">
				<h2>You are logged in as {{ ucfirst(auth()->user()->type) }}</h2>
				<h1>QuizPro Dashboard is under development <i class="fa fa-wrench"></i>...</h1>
			</div>
		</div>
	</div>
</div>
@endpush

@push('included-scripts')
<script src="{{asset('assets/plugins/nvd3/lib/d3.v3.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/nvd3/nv.d3.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/nvd3/src/utils.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/nvd3/src/tooltip.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/nvd3/src/interactiveLayer.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/nvd3/src/models/axis.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/nvd3/src/models/line.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/nvd3/src/models/lineWithFocusChart.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/mapplic/js/hammer.min.js')}}"></script>
<script src="{{asset('assets/plugins/mapplic/js/jquery.mousewheel.js')}}"></script>
<script src="{{asset('assets/plugins/mapplic/js/mapplic.js')}}"></script>
<script src="{{asset('assets/plugins/rickshaw/rickshaw.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-metrojs/MetroJs.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/skycons/skycons.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/dashboard.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/plugins/imagesloaded/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-isotope/isotope.pkgd.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/codrops-dialogFx/dialogFx.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/owl-carousel/owl.carousel.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-nouislider/jquery.nouislider.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/plugins/jquery-nouislider/jquery.liblink.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/gallery.js')}}" type="text/javascript"></script>
@endpush

@push('js')
<script type="text/javascript">
	$(function() {
		$(".page-load").hide();
	});
</script>
@endpush
