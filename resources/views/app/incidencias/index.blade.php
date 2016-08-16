@extends('layout')

@section('title', 'Incidencias')

@section('css_level_plugins')
	<link href="{{ asset("assets/global/plugins/datatables/datatables.min.css") }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<div class="page-content-inner">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet light ">
			<div class="portlet-title">
				<div class="caption font-dark">
					<i class="icon-settings font-dark"></i>
					<span class="caption-subject bold uppercase">Incidencias</span>
				</div>
				<div class="tools"> </div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
					<thead>
					<tr>
						<th class="all">Inicio</th>
						<th class="all">Fin</th>
						<th class="min-tablet">Lugar</th>
						<th class="min-phone-1">Descripción</th>
						<th>Consecuencia</th>
					</tr>
					</thead>
					<tbody>
					@foreach($incidencias as $incidencia)
						<tr>
							<td>{{ $incidencia->fecha_hora_inicio }}</td>
							<td>{{ $incidencia->fecha_hora_fin }}</td>
							<td>{{ $incidencia->lugar }}</td>
							<td>{{ $incidencia->descripcion }}</td>
							<td>{{ $incidencia->consecuencia }}</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
@endsection

@section('js_level_plugins')
	<script src="{{ asset("assets/global/scripts/datatable.js") }}" type="text/javascript"></script>
	<script src="{{ asset("assets/global/plugins/datatables/datatables.min.js") }}" type="text/javascript"></script>
	<script src="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script src="{{ asset("assets/pages/scripts/table-datatables-responsive.min.js") }}" type="text/javascript"></script>
@endsection