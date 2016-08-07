@extends('app.portico.show')

@section('title', $title)

@section('css_level_plugins')
	<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}"
	      rel="stylesheet" type="text/css"/>
	<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}"
	      rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
	@parent
	<li>
		<a href="{{ route('app.reports.portico.report', array('id' => $id, 'report_id' => $report_id)) }}">{{ $title }}</a>
		<i class="fa fa-circle"></i>
	</li>
@endsection
@section('content')
	<div class="page-content-inner">
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light portlet-fit portlet-datatable ">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-settings font-dark"></i>
							<span class="caption-subject font-dark sbold uppercase">{{ $title }}</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-container">
							<table class="table table-striped table-bordered table-hover table-checkable"
							       id="datatable_ajax">
								<thead>
								<tr role="row" class="heading">
									<th width="25%"> Fecha Hora</th>
									<th width="10%"> Placa</th>
									<th width="25%"> Grupo</th>
									<th width="200"> Empresa</th>
									<th width="10%"></th>
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
										<input type="text" class="form-control form-filter input-sm" name="placa">
									</td>
									<td>

									</td>
									<td>
										<input type="text" class="form-control form-filter input-sm"
										       name="empresa">
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
				</div>
				<!-- End: Demo Datatable 1 -->
			</div>
		</div>
	</div>
@endsection

@section('js_level_plugins')
	<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}"
	        type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"
	        type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script>
		jQuery(document).ready(function () {
			$('.date-picker').datepicker({
				rtl: App.isRTL(),
				autoclose: true
			});

			var grid = new Datatable();
			var ajaxParams = {};
			var table = $("#datatable_ajax");

			var setAjaxParams = function(){
				$('textarea.form-filter, select.form-filter, input.form-filter:not([type="radio"],[type="checkbox"])', table).each(function() {
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
						"sProcessing":     "Procesando...",
						"sLengthMenu":     "Mostrar _MENU_ registros",
						"sZeroRecords":    "No se encontraron resultados",
						"sEmptyTable":     "Ningún dato disponible en esta tabla",
						"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
						"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
						"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
						"sInfoPostFix":    "",
						"sSearch":         "Buscar:",
						"sUrl":            "",
						"sInfoThousands":  ",",
						"sLoadingRecords": "Cargando...",
						"oPaginate": {
							"sFirst":    "Primero",
							"sLast":     "Último",
							"sNext":     "Siguiente",
							"sPrevious": "Anterior"
						},
						"oAria": {
							"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
							"sSortDescending": ": Activar para ordenar la columna de manera descendente"
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
					"ajax": {
						"url": "{{ route('service.reports.portico.tipos-vehiculos.empresa', array('id' => $id)) }}", // ajax source
						"data": function (data) {
							setAjaxParams();
							data._token = '{{ csrf_token() }}';
							data.filters = {};
							$.each(ajaxParams, function(key, value) {
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
						{ extend: 'print', className: 'btn dark btn-outline' },
						{ extend: 'pdf', className: 'btn green btn-outline' },
						{ extend: 'csv', className: 'btn purple btn-outline ' }
					],
					"order": [
						[1, "asc"]
					]// set first column as a default sort by asc
				}
			});

			// handle group actionsubmit button click
			grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
				e.preventDefault();
				var action = $(".table-group-action-input", grid.getTableWrapper());
				if (action.val() != "" && grid.getSelectedRowsCount() > 0) {
					grid.setAjaxParam("customActionType", "group_action");
					grid.setAjaxParam("customActionName", action.val());
					grid.setAjaxParam("id", grid.getSelectedRows());
					grid.getDataTable().ajax.reload();
					grid.clearAjaxParams();
				} else if (action.val() == "") {
					App.alert({
						type: 'danger',
						icon: 'warning',
						message: 'Please select an action',
						container: grid.getTableWrapper(),
						place: 'prepend'
					});
				} else if (grid.getSelectedRowsCount() === 0) {
					App.alert({
						type: 'danger',
						icon: 'warning',
						message: 'No record selected',
						container: grid.getTableWrapper(),
						place: 'prepend'
					});
				}
			});
		});
	</script>
@endsection