<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Control Vehicular | @yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    @section('css_global')
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    @show
    <!-- END GLOBAL MANDATORY STYLES -->
	@section('css_level_plugins')
	@show
    <!-- BEGIN THEME GLOBAL STYLES -->
    @section('css_theme')
	<link href="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('assets/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
    @show
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    @section('css_theme_layout')
    <link href="{{ asset('assets/layouts/layout3/css/layout.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/layouts/layout3/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('assets/layouts/layout3/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    @show
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" /> </head>
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
                                    <a href="index.html">
                                    <img src="{{ asset('assets/pages/img/logos/logo.jpg') }}" alt="logo" class="logo-default">
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
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <img alt="" class="img-circle" src="{{ asset('assets/layouts/layout3/img/avatar9.jpg') }}">
                                                <span class="username username-hide-mobile">Usuario</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-default">
                                                <li>
                                                    <a href="#">
                                                        <i class="icon-user"></i> Cambiar Contraseña </a>
                                                    </li>
                                                    <li>
                                                        <a href="#">
                                                            <i class="icon-key"></i> Cerrar Sesión </a>
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
                                                <input type="text" class="form-control" placeholder="ID vehículo" name="query">
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
                                                <li class=" ">
                                                    <a href="{!! route('app.reports.portico.index') !!}">
                                                        Pórticos
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="{!! route('app.reports.empresa.index') !!}">
                                                        Empresas
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="{!! route('app.reports.vehiculo.index') !!}">
                                                        Vehículos
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="{!! route('app.reports.camaras.index') !!}">
                                                        Cámaras
                                                    </a>
                                                </li>
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
                                        </div>
                                    </div>
                                    <!-- END PAGE HEAD-->
                                    <!-- BEGIN PAGE CONTENT BODY -->
                                    <div class="page-content">
                                        <div class="container">
                                            <!-- BEGIN PAGE BREADCRUMBS -->
                                            <ul class="page-breadcrumb breadcrumb">
                                                <li>
                                                    <a href="#">Principal</a>
                                                    <i class="fa fa-circle"></i>
                                                </li>
                                                <li>
                                                    <span>@yield('title')</span>
                                                </li>
                                            </ul>
                                            <!-- END PAGE BREADCRUMBS -->
                                            <!-- BEGIN PAGE CONTENT INNER -->
                                            @section('content')
                                            <div class="page-content-inner">
                                                <div class="note note-info">
                                                    <p> A black page template with a minimal dependency assets to use as a base for any custom page you create </p>
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
<script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
@show
<!-- END CORE PLUGINS -->
@section('js_level_plugins')

@show
<!-- BEGIN THEME GLOBAL SCRIPTS -->
@section('js_global')
<script src="{{ asset('assets/global/scripts/app.js') }}" type="text/javascript"></script>
@show
<!-- END THEME GLOBAL SCRIPTS -->
@section('js_level_scripts')

@show
<!-- BEGIN THEME LAYOUT SCRIPTS -->
@section('js_layout')
<script src="{{ asset('assets/layouts/layout3/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/layout3/scripts/demo.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
@show
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>