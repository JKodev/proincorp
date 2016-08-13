@extends('layout')

@section('title', $empresa->Nom_Empresa)

@section('css_level_plugins')
	<link href="{{ asset("assets/global/plugins/datatables/datatables.min.css") }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") }}"
	      rel="stylesheet" type="text/css"/>
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
				<table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="row_group">
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
						<td>11/07/16 05:39 AM</td>
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
						<td>11/07/16 08:15 PM</td>
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
						<td>11/07/16 08:24 PM</td>
						<td>OMNIBUS</td>
						<td>V9W955</td>
						<td>1_1 PUENTE TINGO AQP-CV</td>
					</tr>
					</tbody>
				</table>
				<table class="table table-striped table-bordered table-hover dt-responsive table-checkable" width="100%"
				       id="datatable_ajax">
					<thead>
					<tr role="row" class="heading">
						<th width="100"> Fecha Hora</th>
						<th width="min-phone-1"> Tag</th>
						<th width="50"> Placa</th>
						<th width="min-tablet"> Portico</th>
						<th width="60"></th>
					</tr>
					<tr role="row" class="filter">
						<td>
							<div class="input-group date date-picker margin-bottom-5"
							     data-date-format="dd/mm/yyyy">
								<input type="text" class="form-control form-filter input-sm" readonly
								       name="date_from" placeholder="Desde">
								<span class="input-group-btn">
                                    <button class="btn btn-sm default"
                                            type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
							</div>
							<div class="input-group date date-picker" data-date-format="dd/mm/yyyy">
								<input type="text" class="form-control form-filter input-sm" readonly
								       name="date_to" placeholder="Hasta">
								<span class="input-group-btn">
                                    <button class="btn btn-sm default"
                                            type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
							</div>
						</td>
						<td>
							<input type="text" class="form-control form-filter input-sm" name="tag">
						</td>
						<td>
							<input type="text" class="form-control form-filter input-sm" name="placa">
						</td>
						<td>
							<input type="text" class="form-control form-filter input-sm"
							       name="portico">
						</td>

						<td>
							<div class="margin-bottom-5">
								<button class="btn btn-sm green btn-outline filter-submit margin-bottom">
									<i class="fa fa-search"></i> Buscar
								</button>
							</div>
							<button class="btn btn-sm red btn-outline filter-cancel">
								<i class="fa fa-times"></i> Limpiar
							</button>
						</td>
					</tr>
					</thead>
					<tbody></tbody>
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
	<!--<script src="{{ asset("assets/pages/scripts/table-datatables-responsive.js") }}" type="text/javascript"></script>-->
	<script>
		jQuery(document).ready(function () {
			$('.date-picker').datepicker({
				rtl: App.isRTL(),
				autoclose: true
			});

			var grid = new Datatable();
			var ajaxParams = {};
			var table = $("#datatable_ajax");

			var setAjaxParams = function () {
				$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function () {
					ajaxParams[$(this).attr("name")] = $(this).val();
				});
			};

			grid.init({
				src: table,
				onSuccess: function (grid, response) {
					// grid:        grid object
					// response:    json object of server side ajax response
					// execute some code after table records loaded
				},
				onError: function (grid) {
					// execute some code on network or other general error
				},
				onDataLoad: function (grid) {
					// execute some code on ajax data load
				},
				loadingMessage: 'Cargando...',
				dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options
					"language": {
						"metronicAjaxRequestGeneralError": "No se pudo completar la petición. Por favor, revise su conexión de internet.",
						"sProcessing": "Procesando...",
						"sLengthMenu": "Mostrar _MENU_ registros",
						"sZeroRecords": "No se encontraron resultados",
						"sEmptyTable": "Ningún dato disponible en esta tabla",
						"sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix": "",
						"sSearch": "Buscar:",
						"sUrl": "",
						"sInfoThousands": ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst": "Primero",
							"sLast": "Último",
							"sNext": "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending": ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
						},
						"lengthMenu": "<span class='seperator'>|</span>Mostrar _MENU_ registros",
						"info": "<span class='seperator'>|</span>Encontrados _TOTAL_ registros",
						"infoEmpty": "No se encontraron registros para mostrar",
						"emptyTable": "No hay datos disponibles en la tabla",
						"zeroRecords": "No se encontraron datos.",
						"paginate": {
							"previous": "Anterior",
							"next": "Siguiente",
							"last": "Último",
							"first": "Primero",
							"page": "Página",
							"pageOf": "de"
						}
					},
					// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
					// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js).
					// So when dropdowns used the scrollable div should be removed.
					//"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

					"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

					"lengthMenu": [
						[10, 20, 50, 100, 150, -1],
						[10, 20, 50, 100, 150, "Todo"] // change per page values here
					],
					"pageLength": 10, // default record count per page
					"columnDefs": [
						{ "visible": false, "targets": 3 }
					],
					"order": [[ 3, 'asc' ]],
					"displayLength": 25,
					"drawCallback": function ( settings ) {
						var api = this.api();
						var rows = api.rows( {page:'current'} ).nodes();
						var last=null;

						api.column(3, {page:'current'} ).data().each( function ( group, i ) {
							if ( last !== group ) {
								$(rows).eq( i ).before(
										'<tr class="group"><td colspan="3">'+group+'</td></tr>'
								);

								last = group;
							}
						} );
					}
					"ajax": {
						"url": "{{ route('service.reports.empresa.report', array('id' => $id)) }}", // ajax source
						"data": function (data) {
							setAjaxParams();
							data._token = '{{ csrf_token() }}';
							data.filters = {};
							$.each(ajaxParams, function (key, value) {
								data.filters[key] = value;
							});
							console.log(data);
							App.blockUI({
								message: "Cargando...",
								target: table.parents(".table-container"),
								overlayColor: 'none',
								cenrerY: true,
								boxed: true
							});
						}
					},
					buttons: [
						{extend: 'print', className: 'btn dark btn-outline'},
						{extend: 'pdf', className: 'btn green btn-outline'},
						{extend: 'csv', className: 'btn purple btn-outline '}
					]
				}
			});
			// Order by the grouping
			$('#row_group tbody').on( 'click', 'tr.group', function () {
				var currentOrder = table.order()[0];
				if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
					table.order( [ 3, 'desc' ] ).draw();
				}
				else {
					table.order( [ 3, 'asc' ] ).draw();
				}
			} );
		});
	</script>
@endsection