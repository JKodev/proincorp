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
						<span class="caption-subject font-blue bold uppercase">Porticos</span>
					</div>
				</div>
				<div class="portlet-body">
				@foreach($lectores as $lector)
					<a href="{{ route('app.reports.portico.show', array('id' => $lector->id_lector_movimiento)) }}" class="btn btn-block btn-lg {{ $colors[intval(current(explode("_", $lector->dsc_lector_movimiento))) % count($colors)] }}">
						<span class="fa fa-car"></span>
						{{ preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento) }}
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
						<span class="caption-subject font-blue bold uppercase">@yield('title_content_portico')</span>
					</div>
				</div>
				<div class="portlet-body">
					@section('content_portico')
					<div id="gmap_marker" class="gmaps"> </div>
					@show
				</div>
			</div>
			<!-- END MARKERS PORTLET-->
			@section('extra-portlets')

			@show
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
		@foreach($lectores as $lector)
		map.addMarker({
			position: {{ \App\Helpers\CamaraStaticHelper::getPositionFromLector($lector->id_lector_movimiento) }},
			title: '{{ preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento) }}',
			details: {
				database_id: 42,
				author: 'HPNeo'
			},
			click: function (e) {
				document.location.href = "{{ route('app.reports.portico.show', array('id' => $lector->id_lector_movimiento)) }}";
			}
		});
		@endforeach
	</script>
@endsection