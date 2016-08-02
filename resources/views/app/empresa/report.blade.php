@extends('layout')

@section('title', $empresa->Nom_Empresa)

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
					<span class="caption-subject bold uppercase">{{ $empresa->Nom_Empresa }}</span>
				</div>
				<div class="tools"> </div>
			</div>
			<div class="portlet-body">
				<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
					<thead>
					<tr>
						<th class="all">Fecha y Hora</th>
						<th class="all">Grupo de Vehículo</th>
						<th class="min-tablet">ID Vehículo</th>
						<th class="min-phone-1">Portico</th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td>11/07/16 06:04 AM</td>
							<td>CAMIONETA</td>
							<td>W4T847</td>
							<td>1_1 PUENTE TINGO AQP-CV</td>
						</tr>
						<tr>
							<td>11/07/16 05:37 AM</td>
							<td>MICROBUS</td>
							<td>V2Z196</td>
							<td>1_1 PUENTE TINGO AQP-CV</td>
						</tr>
						<tr>
							<td>11/07/16 05:39 AM </td>
							<td>OMNIBUS</td>
							<td>V9W955</td>
							<td>1_1 PUENTE TINGO AQP-CV</td>
						</tr>
						<tr>
							<td>11/07/16 01:09 PM</td>
							<td>CAMIONETA</td>
							<td>C7Z743</td>
							<td>1_2 PUENTE TINGO CV-AQP</td>
						</tr>
						<tr>
							<td>11/07/16 03:33 PM</td>
							<td>CAMIONETA</td>
							<td>C7Z743</td>
							<td>1_2 PUENTE TINGO CV-AQP</td>
						</tr>
						<tr>
							<td>11/07/16 08:15 PM </td>
							<td>MICROBUS</td>
							<td>V2Z196</td>
							<td>1_2 PUENTE TINGO CV-AQP</td>
						</tr>
						<tr>
							<td>11/07/16 07:54 AM</td>
							<td>OMNIBUS</td>
							<td>V9W955</td>
							<td>1_2 PUENTE TINGO CV-AQP</td>
						</tr>
						<tr>
							<td>11/07/16 08:24 PM </td>
							<td>OMNIBUS</td>
							<td>V9W955</td>
							<td>1_1 PUENTE TINGO AQP-CV</td>
						</tr>
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
	<script src="{{ asset("assets/pages/scripts/table-datatables-responsive.js") }}" type="text/javascript"></script>
@endsection