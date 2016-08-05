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

						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12">
								<form action="#" class="form-horizontal form-bordered">
									<div class="form-group">
										<label class="control-label col-md-3">Reporte por Fechas</label>
										<div class="col-md-4">
											<div class="input-group input-large date-picker input-daterange"
											     data-date="{{ date('d/m/Y') }}" data-date-format="dd/mm/yyyy">
												<input type="text" class="form-control" id="from" name="from">
												<span class="input-group-addon"> a </span>
												<input type="text" class="form-control" id="to" name="to"></div>
											<span class="help-block"> Seleccione rango de fechas </span>
										</div>
										<div class="col-md-3">
											<button class="btn btn-success" id="show-report" type="button">
												Mostrar Reporte
											</button>
										</div>
									</div>
								</form>
							</div>
						</div>
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

		var route = '/service/reports/portico/{{ $id }}/{start_date}/{end_date}/';
		var getData = function () {
			var start = $('#from').val();
			var end = $('#to').val();
			if (start == '' || start === null) {
				start = '{{ date('d/m/Y') }}';
			}
			if (end == '' || end === null) {
				end = '{{ date('d/m/Y') }}';
			}

			var start_unix = moment(start, "DD/MM/YYYY").unix();
			var end_unix = moment(end, "DD/MM/YYYY").unix();
			var n_route = route.replace('{start_date}', start_unix);
			n_route = n_route.replace('{end_date}', end_unix);

			var data = "";
			$.ajax({
				'url': n_route,
				'dataType': 'json',
				'success': function (response) {
					console.log(response);
					data = response;
				}
			});

			return data;
		};

		var chart = AmCharts.makeChart("chartdiv",
				{
					"type": "pie",
					"balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
					"labelRadius": 10,
					"titleField": "Tip_Vehiculo",
					"valueField": "Expr1",
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

					//"dataProvider": getData()
				}
		);
		chart.dataProvider = getData();
		chart.validateData();

		$('#show-report').click(function () {
			var d = getData();
			console.log(d);
			chart.dataProvider = d;
			chart.validateData();
			chart.animateAgain();
		});
	</script>
@endsection