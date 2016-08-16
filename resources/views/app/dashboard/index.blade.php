@extends('layout')

@section('title', 'Principal')

@section('content')
<div class="page-content-inner">
	<div class="row widget-row">
		@permission('view-portico')
		<div class="col-md-3">
			<!-- BEGIN WIDGET THUMB -->
			<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
				<h4 class="widget-thumb-heading">Porticos</h4>
				<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-green fa fa-map-marker"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-subtitle">
							<a href="{{ route('app.reports.portico.index') }}">
								<i class="fa fa-line-chart"></i>
								Ver Reportes
							</a>
						</span>
					</div>
				</div>
			</div>
			<!-- END WIDGET THUMB -->
		</div>
		@endpermission
		@permission('view-empresas')
		<div class="col-md-3">
			<!-- BEGIN WIDGET THUMB -->
			<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
				<h4 class="widget-thumb-heading">Empresas</h4>
				<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-red fa fa-industry"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-subtitle">
							<a href="{{ route('app.reports.empresa.index') }}">
								<i class="fa fa-line-chart"></i>
								Ver Empresas
							</a>
						</span>
					</div>
				</div>
			</div>
			<!-- END WIDGET THUMB -->
		</div>
		@endpermission
		@permission('view-vehiculos')
		<div class="col-md-3">
			<!-- BEGIN WIDGET THUMB -->
			<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
				<h4 class="widget-thumb-heading">Vehículos</h4>
				<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-purple fa fa-truck"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-subtitle">
							<a href="{{ route('app.reports.vehiculo.index') }}">
								<i class="fa fa-line-chart"></i>
								Ver Vehículos
							</a>
						</span>
					</div>
				</div>
			</div>
			<!-- END WIDGET THUMB -->
		</div>
		@endpermission
		@permission('view-camaras')
		<div class="col-md-3">
			<!-- BEGIN WIDGET THUMB -->
			<div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 ">
				<h4 class="widget-thumb-heading">Cámaras</h4>
				<div class="widget-thumb-wrap">
					<i class="widget-thumb-icon bg-blue fa fa-video-camera"></i>
					<div class="widget-thumb-body">
						<span class="widget-thumb-subtitle">
							<a href="{{ route('app.reports.camaras.index') }}">
								<i class="fa fa-line-chart"></i>
								Ver Cámaras
							</a>
						</span>
					</div>
				</div>
			</div>
			<!-- END WIDGET THUMB -->
		</div>
		@endpermission
	</div>
</div>
@endsection