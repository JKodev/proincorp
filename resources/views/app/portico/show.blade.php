@extends('app.portico.index')

@section('title', preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento))

@section('breadcrumb')
	@parent
	<li>
		<a href="{{ route('app.reports.portico.show', array('id' => $lector->id_lector_movimiento)) }}">{{ preg_replace('/(\d+)\_(\d+)/', " ", $lector->dsc_lector_movimiento) }}</a>
		<i class="fa fa-circle"></i>
	</li>
@endsection

@section('title_content_portico', 'Reportes')

@section('content_portico')

	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 margin-bottom-10">
			<div class="dashboard-stat blue">
				<div class="visual">
					<i class="fa fa-columns fa-icon-medium"></i>
				</div>
				<div class="details">
					<div class="number"> {{ $totals['autos_dia'] }}</div>
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
					<div class="number"> {{ $totals['vehiculos_tipo'] }}</div>
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
					<div class="number"> {{ $totals['vehiculos_empresas'] }}</div>
					<div class="desc"> Vehículos de Empresas</div>
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
					<div class="number"> {{ $totals['camaras'] }}</div>
					<div class="desc"> Reporte lectura de Cámaras</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.camaras', array('id' => $lector->id_lector_movimiento)) }}"> Ver Reporte
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
					<div class="number"> {{ $totals['tags'] }}</div>
					<div class="desc"> Reporte lectura de Tags</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.tags', array('id' => $lector->id_lector_movimiento)) }}"> Ver Reporte
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
					<div class="number"> {{ $totals['general'] }}</div>
					<div class="desc"> Reporte lectura General</div>
				</div>
				<a class="more" href="{{ route('app.reports.portico.general', array('id' => $lector->id_lector_movimiento)) }}"> Ver Reporte
					<i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
	</div>
@endsection

@section('extra-portlets')
	<div class="portlet light portlet-fit ">
		<div class="portlet-title">
			<div class="caption">
				<i class=" icon-layers font-blue"></i>
				<span class="caption-subject font-blue bold uppercase">Avisos</span>
			</div>
			<div class="actions">
				<a href="{{ route('app.reports.portico.avisos.create', array('id' => $lector->id_lector_movimiento)) }}" class="btn green-jungle">
					<span class="glyphicon glyphicon-bullhorn"></span>
					Nuevo Aviso
				</a>
			</div>
		</div>
		<div class="portlet-body">
			<div class="table-scrollable">
				<table class="table table-bordered table-hover">
					<thead>
					<tr>
						<th> Horario </th>
						<th> Lunes </th>
						<th> Martes </th>
						<th> Miércoles </th>
						<th> Jueves </th>
						<th> Viernes </th>
						<th> Sábado </th>
						<th> Domingo </th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					@foreach($advertisements as $advertisement)
					<tr>
						<td>
							{{ date('H:i:s', strtotime($advertisement->start_hour)) }}
							-
							{{ date('H:i:s', strtotime($advertisement->end_hour)) }}
						</td>
						<td>
							@if($advertisement->monday)
								@foreach($advertisement->pictures as $picture)
									<a data-image="{{ asset($picture->path) }}" rel="popover">{{ $picture->code }}</a>
								@endforeach
							@endif
						</td>
						<td>
							@if($advertisement->tuesday)
								@foreach($advertisement->pictures as $picture)
									<a data-image="{{ asset($picture->path) }}" rel="popover">{{ $picture->code }}</a>
								@endforeach
							@endif
						</td>
						<td>
							@if($advertisement->wednesday)
								@foreach($advertisement->pictures as $picture)
									<a data-image="{{ asset($picture->path) }}" rel="popover">{{ $picture->code }}</a>
								@endforeach
							@endif
						</td>
						<td>
							@if($advertisement->thursday)
								@foreach($advertisement->pictures as $picture)
									<a data-image="{{ asset($picture->path) }}" rel="popover">{{ $picture->code }}</a>
								@endforeach
							@endif
						</td>
						<td>
							@if($advertisement->friday)
								@foreach($advertisement->pictures as $picture)
									<a data-image="{{ asset($picture->path) }}" rel="popover">{{ $picture->code }}</a>
								@endforeach
							@endif
						</td>
						<td>
							@if($advertisement->saturday)
								@foreach($advertisement->pictures as $picture)
									<a data-image="{{ asset($picture->path) }}" rel="popover">{{ $picture->code }}</a>
								@endforeach
							@endif
						</td>
						<td>
							@if($advertisement->sunday)
								@foreach($advertisement->pictures as $picture)
									<a data-image="{{ asset($picture->path) }}" rel="popover">{{ $picture->code }}</a>
								@endforeach
							@endif
						</td>
						<td>
							<a href="#" class="btn red-thunderbird">
								<span class="fa fa-trash"></span>
								Eliminar
							</a>
						</td>
					</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('js_level_scripts')
	<script>
		$(document).ready(function () {
			$('a[rel=popover]').popover({
				html: true,
				trigger: 'hover',
				placement: 'top',
				content: function(){return '<img style="width: 200px" src="'+$(this).data('image') + '" />';}
			});
		});
	</script>
@endsection