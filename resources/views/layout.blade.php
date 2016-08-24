<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" ng-app="proincorpApp">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8"/>
	<title>Control Vehicular | @yield('title')</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	@section('css_global')
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
		      type="text/css"/>
		<link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"
		      type="text/css"/>
		<link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet"
		      type="text/css"/>
		<link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
		      type="text/css"/>
		<link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet"
		      type="text/css"/>
	@show
<!-- END GLOBAL MANDATORY STYLES -->
	@section('css_level_plugins')
	@show
<!-- BEGIN THEME GLOBAL STYLES -->
	@section('css_theme')
		<link href="{{ asset('assets/global/plugins/typeahead/typeahead.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet"
		      type="text/css"/>
		<link href="{{ asset('assets/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components"
		      type="text/css"/>
		<link href="{{ asset('assets/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css"/>

	@show
<!-- END THEME GLOBAL STYLES -->
	<!-- BEGIN THEME LAYOUT STYLES -->
	@section('css_theme_layout')
		<link href="{{ asset('assets/layouts/layout3/css/layout.css') }}" rel="stylesheet" type="text/css"/>
		<link href="{{ asset('assets/layouts/layout3/css/themes/default.min.css') }}" rel="stylesheet" type="text/css"
		      id="style_color"/>
		<link href="{{ asset('assets/layouts/layout3/css/custom.min.css') }}" rel="stylesheet" type="text/css"/>
@show
<!-- END THEME LAYOUT STYLES -->
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}"/>
</head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-md">
<div class="page-wrapper">
	<div class="page-wrapper-row">
		<div class="page-wrapper-top">
			<!-- BEGIN HEADER -->
			<div class="page-header">
				<!-- BEGIN HEADER TOP -->
				<div class="page-header-top">
					<div class="container">
						<!-- BEGIN LOGO -->
						<div class="page-logo">
							<a href="{{ route('app.dashboard') }}">
								<img src="{{ asset('assets/pages/img/logos/logo.jpg') }}" alt="logo"
								     class="logo-default">
							</a>
						</div>
						<!-- END LOGO -->
						<!-- BEGIN RESPONSIVE MENU TOGGLER -->
						<a href="javascript:;" class="menu-toggler"></a>
						<!-- END RESPONSIVE MENU TOGGLER -->
						<!-- BEGIN TOP NAVIGATION MENU -->
						<div class="top-menu">
							<ul class="nav navbar-nav pull-right">
								<li class="droddown dropdown-separator">
									<span class="separator"></span>
								</li>
								<!-- BEGIN USER LOGIN DROPDOWN -->
								<li class="dropdown dropdown-user dropdown-dark">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"
									   data-hover="dropdown" data-close-others="true">
										<span class="username username-hide-mobile">{{ Auth::user()->name }}</span>
									</a>
									<ul class="dropdown-menu dropdown-menu-default">

										<li>
											<a href="{{ route('auth.logout.getLogout') }}">
												<i class="icon-key"></i> Cerrar Sesión
											</a>
										</li>
									</ul>
								</li>
								<!-- END USER LOGIN DROPDOWN -->
							</ul>
						</div>
						<!-- END TOP NAVIGATION MENU -->
					</div>
				</div>
				<!-- END HEADER TOP -->
				<!-- BEGIN HEADER MENU -->
				<div class="page-header-menu">
					<div class="container">
						<!-- BEGIN HEADER SEARCH BOX -->
						<form class="search-form" action="#" method="GET">
							<div class="input-group">
								<input type="text" class="form-control" id="vehiculo" placeholder="Placa vehículo"
								       name="query">
								<span class="input-group-btn">
                                    <a href="javascript:;" class="btn submit">
                                        <i class="icon-magnifier"></i>
                                    </a>
                                </span>
							</div>
						</form>
						<!-- END HEADER SEARCH BOX -->
						<!-- BEGIN MEGA MENU -->
						<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
						<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
						<div class="hor-menu  ">
							<ul class="nav navbar-nav">
								<li class=" ">
									<a href="{!! route('app.dashboard') !!}">
										Principal
									</a>
								</li>
								@permission('view-portico')
								<li class=" ">
									<a href="{!! route('app.reports.portico.index') !!}">
										Pórticos
									</a>
								</li>
								@endpermission
								@permission('view-empresas')
								<li class=" ">
									<a href="{!! route('app.reports.empresa.index') !!}">
										Empresas
									</a>
								</li>
								@endpermission
								@permission('view-vehiculos')
								<li class=" ">
									<a href="{!! route('app.reports.vehiculo.index') !!}">
										Vehículos
									</a>
								</li>
								@endpermission
								@permission('view-camaras')
								<li class=" ">
									<a href="{!! route('app.reports.camaras.index') !!}">
										Cámaras
									</a>
								</li>
								@endpermission
								@permission('view-incidencias')
								<li class=" ">
									<a href="{!! route('app.reports.incidencias.index') !!}">
										Incidencias
									</a>
								</li>
								@endpermission
								@role('admin')
								<li class=" ">
									<a href="{!! route('app.settings.users.index') !!}">
										Usuarios
									</a>
								</li>
								@endrole
							</ul>
						</div>
						<!-- END MEGA MENU -->
					</div>
				</div>
				<!-- END HEADER MENU -->
			</div>
			<!-- END HEADER -->
		</div>
	</div>
	<div class="page-wrapper-row full-height">
		<div class="page-wrapper-middle">
			<!-- BEGIN CONTAINER -->
			<div class="page-container">
				<!-- BEGIN CONTENT -->
				<div class="page-content-wrapper">
					<!-- BEGIN CONTENT BODY -->
					<!-- BEGIN PAGE HEAD-->
					<div class="page-head">
						<div class="container">
							<!-- BEGIN PAGE TITLE -->
							<div class="page-title">
								<h1>@yield('title') </h1>
							</div>
							<!-- END PAGE TITLE -->
							<div class="page-toolbar">
								<button type="button" style="margin-top: 15px" class="btn blue-hoki dropdown dropdown-extended quick-sidebar-toggler">
									<span class="glyphicon glyphicon-road"></span>
									Tiempo Real
								</button>
							</div>
						</div>
					</div>
					<!-- END PAGE HEAD-->
					<!-- BEGIN PAGE CONTENT BODY -->
					<div class="page-content">
						<div class="container">
							<!-- BEGIN PAGE BREADCRUMBS -->
							<ul class="page-breadcrumb breadcrumb">
								<li>
									<a href="{{ route('app.dashboard') }}">Principal</a>
									<i class="fa fa-circle"></i>
								</li>
								@section('breadcrumb')

								@show
							</ul>
							<!-- END PAGE BREADCRUMBS -->
							<!-- BEGIN PAGE CONTENT INNER -->
							@section('content')
								<div class="page-content-inner">
									<div class="note note-info">
										<p> A black page template with a minimal dependency assets to use as a base for
											any custom page you create </p>
									</div>
								</div>
						@show
						<!-- END PAGE CONTENT INNER -->
						</div>
					</div>
					<!-- END PAGE CONTENT BODY -->
					<!-- END CONTENT BODY -->
				</div>
				<!-- END CONTENT -->
				<!-- BEGIN QUICK SIDEBAR -->
				<a href="javascript:;" class="page-quick-sidebar-toggler">
					<i class="icon-login"></i>
				</a>
				<div class="page-quick-sidebar-wrapper" data-close-on-body-click="false" ng-controller="VehicleFlowController">
					<div class="page-quick-sidebar">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Vehículos
									<span class="badge badge-danger">20</span>
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
								<div class="page-quick-sidebar-chat-users" data-rail-color="#ddd"
								     data-wrapper-class="page-quick-sidebar-list">
									<h3 class="list-heading">Vehiculos Tiempo Real</h3>
									<ul class="media-list list-items">
										<li class="media" ng-repeat="vehicle in vehicles">
											<div class="media-status">
												<span class="badge badge-success"></span>
											</div>
											<img class="media-object" ng-src="@{{ vehicle.image }}"
											     alt="...">
											<div class="media-body">
												<h4 class="media-heading"><strong>@{{ vehicle.lector }}</strong> <br>@{{ vehicle.placa }}</h4>
												<div class="media-heading-sub">@{{ vehicle.empresa }} <br>@{{ vehicle.date }}</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- END QUICK SIDEBAR -->
			</div>
			<!-- END CONTAINER -->
		</div>
	</div>
	<div class="page-wrapper-row">
		<div class="page-wrapper-bottom">
			<!-- BEGIN FOOTER -->
			<!-- BEGIN INNER FOOTER -->
			<div class="page-footer">
				<div class="container">
					{{ date('Y') }} &copy;
				</div>
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
			<!-- END INNER FOOTER -->
			<!-- END FOOTER -->
		</div>
	</div>
</div>
<!--[if lt IE 9]>
<script src="{{ asset('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ asset('assets/global/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
@section('js_core')
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
	<script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"
	        type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"
	        type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/typeahead/handlebars.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/typeahead/typeahead.bundle.min.js') }}"
	        type="text/javascript"></script>
	<script>
		var app = angular.module('proincorpApp', []);
		app.controller('VehicleFlowController', ['$http', '$scope', function ($http, $scope) {
			$scope.route = '{{ route('service.reports.vehiculo.flow') }}';
			$scope.date = '{{ date('Y-m-d H:i:s') }}';

			$scope.vehicles= [];

			$scope.getVehicles = function () {
				$http({
					method: 'GET',
					url: '{{ route('service.reports.vehiculo.flow') }}',
					headers: {
						'Content-type': 'application/json'
					},
					data: JSON.stringify({
						date: $scope.date
					})
				}).then(function (response) {
					if (response.data.success)
						$scope.vehicles = response.data.results;
					else
						toastr.error('Lo sentimos, no hemos podido actualizar los datos.');
				})
			};

			$scope.getVehicles();

			setInterval(function () {
				$scope.getVehicles();
			}, 10000);
		}]);
	</script>
@show
<!-- END CORE PLUGINS -->
@section('js_level_plugins')

@show
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('assets/global/scripts/app.js') }}" type="text/javascript"></script>
@section('js_global')

@show
<!-- END THEME GLOBAL SCRIPTS -->
<script>
	$(document).ready(function () {
		var vehiculos = new Bloodhound({
			datumTokenizer: function (d) {
				return d.tokens;
			},
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				wildcard: '%QUERY',
				url: '{{ route('service.reports.vehiculo.find') }}?query=%QUERY',
			}
		});

		$('#vehiculo').typeahead(null, {
			display: 'value',
			source: vehiculos,
			templates: {
				empty: [
					'<div class="empty-message">',
					'No se ha encontrado la placa.',
					'</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<div><strong>Placa:</strong> @{{value}}<br><strong>Marca: </strong>@{{brand}} <br><strong>Tipo:</strong> @{{type}}</div>')
			}
		}).bind('typeahead:select', function (ev, suggestion) {
			window.location = '{{ route('app.reports.vehiculo.show') }}?id=' + suggestion.value;
		});
		$('.dropdown-quick-sidebar-toggler a, .page-quick-sidebar-toggler, .quick-sidebar-toggler').click(function (e) {
			$('body').toggleClass('page-quick-sidebar-open');
		});
		var wrapper = $('.page-quick-sidebar-wrapper');
		var wrapperChat = wrapper.find('.page-quick-sidebar-chat');

		var initChatSlimScroll = function () {
			var chatUsers = wrapper.find('.page-quick-sidebar-chat-users');
			var chatUsersHeight;

			chatUsersHeight = wrapper.height() - wrapper.find('.nav-tabs').outerHeight(true);

			// chat user list
			App.destroySlimScroll(chatUsers);
			chatUsers.attr("data-height", chatUsersHeight);
			App.initSlimScroll(chatUsers);

			var chatMessages = wrapperChat.find('.page-quick-sidebar-chat-user-messages');
			var chatMessagesHeight = chatUsersHeight - wrapperChat.find('.page-quick-sidebar-chat-user-form').outerHeight(true);
			chatMessagesHeight = chatMessagesHeight - wrapperChat.find('.page-quick-sidebar-nav').outerHeight(true);

			// user chat messages
			App.destroySlimScroll(chatMessages);
			chatMessages.attr("data-height", chatMessagesHeight);
			App.initSlimScroll(chatMessages);
		};

		initChatSlimScroll();
		App.addResizeHandler(initChatSlimScroll); // reinitialize on window resize

		wrapper.find('.page-quick-sidebar-chat-users .media-list > .media').click(function () {
			wrapperChat.addClass("page-quick-sidebar-content-item-shown");
		});

		wrapper.find('.page-quick-sidebar-chat-user .page-quick-sidebar-back-to-list').click(function () {
			wrapperChat.removeClass("page-quick-sidebar-content-item-shown");
		});

		var handleChatMessagePost = function (e) {
			e.preventDefault();

			var chatContainer = wrapperChat.find(".page-quick-sidebar-chat-user-messages");
			var input = wrapperChat.find('.page-quick-sidebar-chat-user-form .form-control');

			var text = input.val();
			if (text.length === 0) {
				return;
			}

			var preparePost = function(dir, time, name, avatar, message) {
				var tpl = '';
				tpl += '<div class="post '+ dir +'">';
				tpl += '<img class="avatar" alt="" src="' + Layout.getLayoutImgPath() + avatar +'.jpg"/>';
				tpl += '<div class="message">';
				tpl += '<span class="arrow"></span>';
				tpl += '<a href="#" class="name">Bob Nilson</a>&nbsp;';
				tpl += '<span class="datetime">' + time + '</span>';
				tpl += '<span class="body">';
				tpl += message;
				tpl += '</span>';
				tpl += '</div>';
				tpl += '</div>';

				return tpl;
			};

			// handle post
			var time = new Date();
			var message = preparePost('out', (time.getHours() + ':' + time.getMinutes()), "Bob Nilson", 'avatar3', text);
			message = $(message);
			chatContainer.append(message);

			chatContainer.slimScroll({
				scrollTo: '1000000px'
			});

			input.val("");

			// simulate reply
			setTimeout(function(){
				var time = new Date();
				var message = preparePost('in', (time.getHours() + ':' + time.getMinutes()), "Ella Wong", 'avatar2', 'Lorem ipsum doloriam nibh...');
				message = $(message);
				chatContainer.append(message);

				chatContainer.slimScroll({
					scrollTo: '1000000px'
				});
			}, 3000);
		};

		wrapperChat.find('.page-quick-sidebar-chat-user-form .btn').click(handleChatMessagePost);
		wrapperChat.find('.page-quick-sidebar-chat-user-form .form-control').keypress(function (e) {
			if (e.which == 13) {
				handleChatMessagePost(e);
				return false;
			}
		});
	});
</script>
@section('js_level_scripts')

@show
<!-- BEGIN THEME LAYOUT SCRIPTS -->
@section('js_layout')

@show
<script src="{{ asset('assets/layouts/layout3/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/layout3/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>