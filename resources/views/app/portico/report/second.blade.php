@extends('layout')

@section('title', $title)

@section('css_level_plugins')
	<link rel="stylesheet" href="http://www.amcharts.com/lib/3/plugins/export/export.css">
	<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
	<div class="page-content-inner">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN EXAMPLE TABLE PORTLET-->
				<div class="portlet light ">
					<div class="portlet-title">
						<div class="caption font-dark">
							<i class="icon-settings font-dark"></i>
							<span class="caption-subject bold uppercase">{{ $title }}</span>
						</div>
						<div class="tools">
							<form action="#" class="form-horizontal form-bordered">
								<div class="form-group">
									<label class="control-label col-md-3">Reporte por Fechas</label>
									<div class="col-md-4">
										<div class="input-group input-large date-picker input-daterange"
										     data-date="10/11/2012" data-date-format="mm/dd/yyyy">
											<input type="text" class="form-control" name="from">
											<span class="input-group-addon"> a </span>
											<input type="text" class="form-control" name="to"></div>
										<span class="help-block"> Seleccione rango de fechas </span>
									</div>
									<div class="col-md-3">
										<button class="btn btn-success" type="button">
											Mostrar Reporte
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="portlet-body">
						<div id="chartdiv" style="width: 100%; height: 600px; background-color: #FFFFFF;"></div>
					</div>
				</div>
				<!-- END EXAMPLE TABLE PORTLET-->
			</div>
		</div>
	</div>
@endsection

@section('js_level_plugins')
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/amcharts.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/pie.js"></script>
	<script type="text/javascript" src="http://www.amcharts.com/lib/3/plugins/export/export.js"></script>
	<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script src="{{ asset('assets/pages/scripts/components-date-time-pickers.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		if (jQuery().datepicker) {
			$('.date-picker').datepicker({
				rtl: App.isRTL(),
				orientation: "left",
				autoclose: true
			});
		}

		AmCharts.makeChart("chartdiv",
				{
					"type": "pie",
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"labelRadius": 10,
					"titleField": "tipo",
					"valueField": "valor",
					"export": {
						"enabled": true
					},
					"allLabels": [],
					"balloon": {},
					"legend": {
						"enabled": true,
						"align": "center",
						"markerType": "circle"
					},
					"titles": [],
					"dataProvider": [
							@foreach($results as $result)
						{
							"tipo": "{{ $result->Tip_Vehiculo }}",
							"valor": "{{ $result->Expr1 }}"
						},
						@endforeach
					]
				}
		);
	</script>
@endsection