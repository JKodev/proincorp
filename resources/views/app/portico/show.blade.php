@extends('app.portico.index')

@section('title', preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento))

@section('breadcrumb')
	@parent
	<li>
		<a href="{{ route('app.reports.portico.show', array('id' => $lector->id_lector_movimiento)) }}">{{ preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento) }}</a>
		<i class="fa fa-circle"></i>
	</li>
@endsection

@section('content_portico')

	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
			<div class="dashboard-stat blue">
				<div class="visual">
					<i class="fa fa-columns fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number">1500</div>
					<div class="desc"> Autos Día</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.report', array('id' => $lector->id_lector_movimiento, 'report_id' => 1)) }}">
					Ver Reporte
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
			<div class="dashboard-stat green-jungle">
				<div class="visual">
					<i class="fa fa-pie-chart fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number"> 500</div>
					<div class="desc">Vehículos por Tipo</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.report', array('id' => $lector->id_lector_movimiento, 'report_id' => 2)) }}">
					Ver Reporte
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
			<div class="dashboard-stat red-thunderbird">
				<div class="visual">
					<i class="fa fa-area-chart fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number">1000</div>
					<div class="desc"> Carros de Empresas</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.report', array('id' => $lector->id_lector_movimiento, 'report_id' => 3)) }}"> Ver Reporte
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
			<div class="dashboard-stat purple-seance">
				<div class="visual">
					<i class="fa fa-bar-chart fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number"> 5000</div>
					<div class="desc"> Vehículos con tags</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.report', array('id' => $lector->id_lector_movimiento, 'report_id' => 4)) }}"> Ver Reporte
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
			<div class="dashboard-stat purple-seance">
				<div class="visual">
					<i class="fa fa-bar-chart fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number"> 5000</div>
					<div class="desc"> Reporte lectura de Tags</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.tags', array('id' => $lector->id_lector_movimiento)) }}"> Ver Reporte
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
	</div>
@endsection