@extends('layout')

@section('title', 'Empresas')

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
				<span class="caption-subject bold uppercase">Empresas</span>
			</div>
			<div class="tools"> </div>
		</div>
		<div class="portlet-body">
			<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
				<thead>
					<tr>
						<th class="all">ID</th>
						<th class="all">Nombre</th>
						<th class="min-tablet">Dirección</th>
						<th class="min-phone-1">Descripción</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					@foreach($empresas as $empresa)
					<tr>
						<td>{{ $empresa->ID_Empresa }}</td>
						<td>{{ $empresa->Nom_Empresa }}</td>
						<td>{{ $empresa->Dir_Empresa }}</td>
						<td>{{ $empresa->Des_Empresa }}</td>
						<td>
							<div class="btn-group pull-right">
								<button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Reports
									<i class="fa fa-angle-down"></i>
								</button>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="javascript:;">
											<i class="fa fa-print"></i> Print 
										</a>
									</li>
									<li>
										<a href="javascript:;">
											<i class="fa fa-file-pdf-o"></i> Save as PDF 
										</a>
									</li>
									<li>
										<a href="javascript:;">
											<i class="fa fa-file-excel-o"></i> Export to Excel 
										</a>
									</li>
								</ul>
							</div>
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