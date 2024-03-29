@extends('layout')

@section('title', 'Vehículos')

@section('css_level_plugins')
<link href="{{ asset("assets/global/plugins/datatables/datatables.min.css") }}" rel="stylesheet" type="text/css" />
<link href="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
	@parent
	<li>
		<a href="{{ route('app.reports.vehiculo.index') }}">Vehículos</a>
		<i class="fa fa-circle"></i>
	</li>
@endsection

@section('content')
<div class="page-content-inner">
	<!-- BEGIN EXAMPLE TABLE PORTLET-->
	<div class="portlet light ">
		<div class="portlet-title">
			<div class="caption font-dark">
				<i class="icon-settings font-dark"></i>
				<span class="caption-subject bold uppercase">Vehículos</span>
			</div>
			<div class="tools"> </div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
				<thead>
					<tr>
						<th class="all">Placa</th>
						<th class="all">Tipo</th>
						<th class="min-tablet">Marca</th>
						<th class="min-phone-1">Observación</th>
						<th class="min-phone-1">Grupo</th>
						<th class="all"></th>
					</tr>
				</thead>
				<tbody>
					@foreach($vehiculos as $vehiculo)
					<tr>
						<td>{{ $vehiculo->ID_Vehiculo }}</td>
						<td>{{ $vehiculo->Tip_Vehiculo }}</td>
						<td>{{ $vehiculo->Mar_Vehiculo }}</td>
						<td>{{ $vehiculo->Obs_Vehiculo }}</td>
						<td>{{ $vehiculo->Gru_Vehiculo }}</td>
						<td>
							<a href="{{ route('app.reports.vehiculo.show', array('id' => $vehiculo->ID_Vehiculo)) }}" class="btn blue-soft">
								Ver Info
							</a>
						</td>
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