@extends('layout')

@section('title', $id)

@section('css_level_plugins')
	<link href="{{ asset("assets/global/plugins/datatables/datatables.min.css") }}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css") }}"
	      rel="stylesheet" type="text/css"/>
@endsection

@section('content')
	<div class="page-content-inner">
		<div class="row">
			<div class="col-md-12">
				<!-- BEGIN PROFILE SIDEBAR -->
				<div class="profile-sidebar">
					<!-- PORTLET MAIN -->
					<div class="portlet light profile-sidebar-portlet ">
						<!-- SIDEBAR USERPIC -->
						<div class="profile-userpic">
							<img src="{{ asset('assets/pages/img/photo_default.png') }}" class="img-responsive" alt="">
						</div>
						<!-- END SIDEBAR USERPIC -->
						<!-- SIDEBAR USER TITLE -->
						<div class="profile-usertitle">
							<div class="profile-usertitle-name"> {{ $vehiculo->ID_Vehiculo }}</div>
							<div class="profile-usertitle-job"> {{ $empresa->Nom_Empresa }}</div>
						</div>
						<!-- END SIDEBAR USER TITLE -->
						<!-- SIDEBAR MENU -->
						<div class="profile-usermenu">
							<ul class="nav">
								<li>
									<i class="icon-home"></i> {{ $vehiculo->Tip_Vehiculo }}
								</li>
								<li>

									<i class="icon-settings"></i> {{ $vehiculo->Mar_Vehiculo }}
								</li>
								<li>
									<i class="icon-info"></i> {{ $vehiculo->Gru_Vehiculo }}
								</li>
							</ul>
						</div>
						<!-- END MENU -->
					</div>
					<!-- END PORTLET MAIN -->
					<!-- PORTLET MAIN -->
					<div class="portlet light ">
						<div>
							<h4 class="profile-desc-title">Observaciones</h4>
							<span class="profile-desc-text">
								{{ $vehiculo->Obs_Vehiculo }}
							</span>

						</div>
					</div>
					<!-- END PORTLET MAIN -->
				</div>
				<!-- END BEGIN PROFILE SIDEBAR -->
				<!-- BEGIN PROFILE CONTENT -->
				<div class="profile-content">
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN PORTLET -->
							<div class="portlet light ">
								<div class="portlet-title">
									<div class="caption caption-md">
										<i class="icon-bar-chart theme-font hide"></i>
										<span class="caption-subject font-blue-madison bold uppercase">Movimiento</span>
									</div>
									<div class="actions">

									</div>
								</div>
								<div class="portlet-body">

								</div>
							</div>
							<!-- END PORTLET -->
						</div>
					</div>
				</div>
				<!-- END PROFILE CONTENT -->
			</div>
		</div>
	</div>
@endsection

@section('js_level_plugins')
	<script src="{{ asset("assets/global/scripts/datatable.js") }}" type="text/javascript"></script>
	<script src="{{ asset("assets/global/plugins/datatables/datatables.min.js") }}" type="text/javascript"></script>
	<script src="{{ asset("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js") }}"
	        type="text/javascript"></script>
@endsection

@section('js_level_scripts')
	<script src="{{ asset("assets/pages/scripts/table-datatables-responsive.min.js") }}"
	        type="text/javascript"></script>
@endsection