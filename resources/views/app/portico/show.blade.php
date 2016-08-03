@extends('layout')

@section('title', 'Reporte de Portico')

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
						<a href="#" class="btn btn-block btn-lg green-jungle">
							<span class="fa fa-car"></span>
							Puente Tingo AQP -> CV
						</a>
						<a href="#" class="btn btn-block btn-lg green-jungle">
							<span class="fa fa-car"></span>
							Puente Tingo CV -> AQP
						</a>
						<a href="#" class="btn btn-block btn-lg red-flamingo">
							<span class="fa fa-car"></span>
							Palacio AQP -> CV
						</a>
						<a href="#" class="btn btn-block btn-lg red-flamingo">
							<span class="fa fa-car"></span>
							Palacio CV -> AQP
						</a>
						<a href="#" class="btn btn-block btn-lg yellow-saffron">
							<span class="fa fa-car"></span>
							Calicanto CV -> AQP
						</a>
						<a href="#" class="btn btn-block btn-lg yellow-saffron">
							<span class="fa fa-car"></span>
							Calicanto AQP -> CV
						</a>

					</div>
				</div>
			</div>
			<div class="col-md-8">
				<!-- BEGIN MARKERS PORTLET-->
				<div class="portlet light portlet-fit ">
					<div class="portlet-title">
						<div class="caption">
							<i class=" icon-layers font-blue"></i>
							<span class="caption-subject font-blue bold uppercase">Reportes</span>
						</div>
					</div>
					<div class="portlet-body">
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
									<a class="more" href="{{ route('app.reports.portico.report', array('id' => $id, 'report_id' => 1)) }}"> Ver Reporte
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
									<a class="more" href="{{ route('app.reports.portico.report', array('id' => $id, 'report_id' => 2)) }}"> Ver Reporte
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
									<a class="more" href="javascript:;"> Ver Reporte
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
									<a class="more" href="javascript:;"> Ver Reporte
										<i class="m-icon-swapright m-icon-white"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END MARKERS PORTLET-->
			</div>

		</div>
	</div>
@endsection