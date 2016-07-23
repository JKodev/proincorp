@extends('layout')

@section('title', 'Reporte de Portico')

@section('content')
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-8">
			<!-- BEGIN MARKERS PORTLET-->
			<div class="portlet light portlet-fit ">
				<div class="portlet-title">
					<div class="caption">
						<i class=" icon-layers font-blue"></i>
						<span class="caption-subject font-blue bold uppercase">Mapa</span>
					</div>
				</div>
				<div class="portlet-body">
					<div id="gmap_marker" class="gmaps"> </div>
				</div>
			</div>
			<!-- END MARKERS PORTLET-->
		</div>
		<div class="col-md-4">
			<div class="portlet light portlet-fit">
				<div class="portlet-title">
					<div class="caption">
						<i class=" icon-layers font-blue"></i>
						<span class="caption-subject font-blue bold uppercase">Porticos</span>
					</div>
				</div>
				<div class="portlet-body">
					<a href="#" class="btn btn-block btn-lg green-jungle">
						<span class="fa fa-car"></span>
						Puente Tingo AQP -> CV
					</a>
					<a href="#" class="btn btn-block btn-lg green-jungle">
						<span class="fa fa-car"></span>
						Puente Tingo CV -> AQP
					</a>
					<a href="#" class="btn btn-block btn-lg red-flamingo">
						<span class="fa fa-car"></span>
						Palacio AQP -> CV
					</a>
					<a href="#" class="btn btn-block btn-lg red-flamingo">
						<span class="fa fa-car"></span>
						Palacio CV -> AQP
					</a>
					<a href="#" class="btn btn-block btn-lg yellow-saffron">
						<span class="fa fa-car"></span>
						Calicanto CV -> AQP
					</a>
					<a href="#" class="btn btn-block btn-lg yellow-saffron">
						<span class="fa fa-car"></span>
						Calicanto AQP -> CV
					</a>
					
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js_level_plugins')
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDsJeLjJDJtTGCf4pQkdHftCL6F8RLxHCo&sensor=false" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
<script src="{{ asset('assets/pages/scripts/maps-google.js') }}" type="text/javascript"></script>
@endsection