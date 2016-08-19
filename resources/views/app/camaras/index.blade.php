@extends('layout')

@section('title', 'Reporte de Portico')

@section('breadcrumb')
	<li>
		<a href="{{ route('app.reports.portico.index') }}">Porticos</a>
		<i class="fa fa-circle"></i>
	</li>
@endsection

@section('content')
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-4">
			<div class="portlet light portlet-fit">
				<div class="portlet-title">
					<div class="caption">
						<i class=" icon-layers font-blue"></i>
						<span class="caption-subject font-blue bold uppercase">Cámaras</span>
					</div>
				</div>
				<div class="portlet-body">
				@foreach($camaras as $camara)
					<a href="{{ route('app.reports.camaras.show', array('id' => $camara->id)) }}" class="btn btn-block btn-lg {{ $colors[intval($camara->id) % count($colors)] }}">
						<span class="fa fa-car"></span>
						{{ preg_replace('/Cam(\d+)\_/', " ", $camara->cameraName) }}
					</a>
				@endforeach
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<!-- BEGIN MARKERS PORTLET-->
			<div class="portlet light portlet-fit ">
				<div class="portlet-title">
					<div class="caption">
						<i class=" icon-layers font-blue"></i>
						<span class="caption-subject font-blue bold uppercase"></span>
					</div>
				</div>
				<div class="portlet-body">
					@section('content_portico')
					<div id="gmap_marker" class="gmaps"> </div>
					@show
				</div>
			</div>
			<!-- END MARKERS PORTLET-->
		</div>

	</div>
</div>
@endsection

@section('js_level_plugins')
<script src="http://maps.google.com/maps/api/js?key=AIzaSyDsJeLjJDJtTGCf4pQkdHftCL6F8RLxHCo&sensor=false" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
<script>
	var map = new GMaps({
		div: '#gmap_marker',
		lat: -16.449965,
		lng: -71.587268
	});
	@foreach($camaras as $camara)
	map.addMarker({
		position: {{ \App\Helpers\CamaraStaticHelper::getPositionFromCamera($camara->id) }},
		title: '{{ preg_replace('/Cam(\d+)\_/', " ", $camara->cameraName) }}',
		details: {
			database_id: 42,
			author: 'HPNeo'
		},
		click: function (e) {
			document.location.href = "{{ route('app.reports.camaras.show', array('id' => $camara->id)) }}";
		}
	});
	@endforeach
</script>
@endsection