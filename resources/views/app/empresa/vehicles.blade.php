@extends('layout')

@section('title', $empresa->Nom_Empresa)

@section('css_level_plugins')
	<link href="{{ asset("assets/global/plugins/datatables/datatables.min.css") }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") }}"
	      rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
	      rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
	<li>
		<a href="{{ route('app.reports.empresa.index') }}">Empresas</a>
		<i class="fa fa-circle"></i>
	</li>
	<li>
		<a href="{{ route('app.reports.empresa.vehicles', array('id'=>$empresa->ID_Empresa)) }}">Vehículos {{ $empresa->Nom_Empresa }}</a>
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
					<span class="caption-subject bold uppercase">{{ $empresa->Nom_Empresa }}</span>
				</div>
				<div class="tools"></div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered dt-responsive" width="100%"
				       id="sample_1">
					<thead>
					<tr role="row" class="heading">
						<th class="all"> Placa</th>
						<th class="all"> Tag</th>
						<th class="all"> Marca</th>
						<th class="all"> Modelo</th>
						<th class="all"> Grupo</th>
						<th class="all hidden-print"></th>
					</tr>
					</thead>
					<tbody>
					@foreach($vehicles as $vehicle)
					<tr>
						<td>{{ $vehicle->ID_Vehiculo }}</td>
						<td>{{ \App\Helpers\ReportHelper::getTagVehicle($vehicle->ID_Vehiculo) }}</td>
						<td>{{ $vehicle->Mar_Vehiculo }}</td>
						<td>{{ $vehicle->Mod_Vehiculo }}</td>
						<td>{{ $vehicle->Gru_Vehiculo }}</td>
						<td class="hidden-print">
							<a href="{{ route('app.reports.vehiculo.show', array('id'=>$vehicle->ID_Vehiculo)) }}" class="btn green-jungle">
								Ver Vehículo
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
	<script src="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") }}"
	        type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script src="{{ asset("assets/pages/scripts/table-datatables-responsive.js") }}" type="text/javascript"></script>
@endsection