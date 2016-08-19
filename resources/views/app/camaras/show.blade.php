@extends('layout')

@section('title', 'Reporte de Portico')

@section('breadcrumb')
	<li>
		<a href="{{ route('app.reports.portico.index') }}">Cámaras</a>
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
						@foreach($camaras as $cam)
							<a href="{{ route('app.reports.camaras.show', array('id' => $cam->id)) }}"
							   class="btn btn-block btn-lg {{ $colors[intval($cam->id) % count($colors)] }}">
								<span class="fa fa-car"></span>
								{{ preg_replace('/Cam(\d+)\_/', " ", $cam->cameraName) }}
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
						<div class="row">
							<iframe src="http://{{ $camara->ipaddress }}/#/" class="col-md-12" style="height:600px; position: relative;" frameborder="0"></iframe>
						</div>
						<div class="row">
						@section('content_portico')
							<div id="gmap_marker" class="gmaps col-md-8"></div>
						@show
						</div>
					</div>
				</div>
				<!-- END MARKERS PORTLET-->
			</div>

		</div>
	</div>
@endsection

@section('js_level_plugins')
	<script src="http://maps.google.com/maps/api/js?key=AIzaSyDsJeLjJDJtTGCf4pQkdHftCL6F8RLxHCo&sensor=false"
			type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script>
		@if ($ubicacion !== null)
		var mapMarker = function () {
			var position = {
				lat: parseFloat('{{ $ubicacion->latitud }}'),
				lng: parseFloat('{{ $ubicacion->longitud }}')
			};

			var contentString = '<div id="content">' +
				'<div id="siteNotice">' +
				'</div>' +
				'<h1 id="firstHeading" class="firstHeading">{{ preg_replace('/Cam(\d+)\_/', " ", $camara->cameraName) }}</h1>' +
				'<div id="bodyContent">' +
							'' +
				'</div>' +
				'</div>';

			var map = new google.maps.Map(document.getElementById('gmap_marker'), {
				zoom: 18,
				center: position
			});

			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			var marker = new google.maps.Marker({
				position: position,
				map: map,
				title: '{{ preg_replace('/Cam(\d+)\_/', " ", $camara->cameraName) }}'
			});

			marker.addListener('click', function () {
				infowindow.open(map, marker);
			});
			/*
			map.addMarker({
				lat: parseFloat('{{ $ubicacion->latitud }}'),
				lng: parseFloat('{{ $ubicacion->longitud }}'),
				title: '{{ preg_replace('/Cam(\d+)\_/', " ", $camara->cameraName) }}',
				details: {
					database_id: parseInt('{{ $camara->id }}'),
					author: 'Proincorp'
				},
				click: function (e) {
					if (console.log) console.log(e);
					infowindow.open(map);
				}
			});
			*/
		};
		mapMarker();
		@else
			toastr.error("Lo sentimos, no hemos podido cargar la ubicación de la cámara.");
		@endif
	</script>
@endsection