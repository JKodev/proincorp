<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', [
	'as'    =>  'app.init',
	'uses'  =>  function() {
		if (Auth::check()) {
			return redirect()->route('app.dashboard');
		}
		return redirect()->route('auth.login.getLogin');
	}
]);

Route::group([
	'prefix'	=>	'app',
	'middleware'    =>  'auth'
	], function () {

		Route::get('/', [
			'as'	=>	'app.dashboard',
			'uses'	=>	'DashboardController@index'
		]);

		Route::group([
			'prefix'	=>	'/reports'
			], function () {

				Route::group([
					'prefix'	=>	'portico'
					], function () {
						
						Route::get('/', [
							'as'	=>	'app.reports.portico.index',
							'uses'	=>	'PorticoController@index'
						]);

                        Route::get('/{id}', [
                            'as'    =>  'app.reports.portico.show',
                            'uses'  =>  'PorticoController@show'
                        ]);

						Route::get('/{id}/report/{report_id}', [
							'as'    =>  'app.reports.portico.report',
							'uses'  =>  'PorticoController@report'
						]);

						Route::get('/{id}/tags', [
							'as'    =>  'app.reports.portico.tags',
							'uses'  =>  'PorticoController@tags'
						]);

						Route::get('/{id}/camaras', [
							'as'    =>  'app.reports.portico.camaras',
							'uses'  =>  'PorticoController@camaras'
						]);

						Route::get('/{id}/general', [
							'as'    =>  'app.reports.portico.general',
							'uses'  =>  'PorticoController@general'
						]);
				});

				Route::group([
					'prefix' 	=>	'empresa'
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.empresa.index',
				    		'uses'	=>	'EmpresaController@index'
				    	]);

						Route::get('/{id}/report/', [
							'as'    =>  'app.reports.empresa.report',
							'uses'  =>  'EmpresaController@report'
						]);
				});

				Route::group([
					'prefix' 	=>	'camaras'
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.camaras.index',
				    		'uses'	=>	'CamarasController@index'
				    	]);

						Route::get('/{id}', [
							'as'    =>  'app.reports.camaras.show',
							'uses'  =>  'CamarasController@show'
						]);
				});

				Route::group([
					'prefix' 	=>	'vehiculo'
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.vehiculo.index',
				    		'uses'	=>	'VehiculoController@index'
				    	]);

						Route::get('/{id}', [
							'as'    =>  'app.reports.vehiculo.show',
							'uses'  =>  'VehiculoController@show'
						]);
				});
		});
});

Route::group([
	'middleware'    =>  'auth',
	'prefix'    =>  'service'
], function () {

	Route::group([
		'prefix'    =>  'reports'
	], function () {
		Route::group([
			'prefix'    =>  'portico'
		], function () {

			Route::get('/porcentual/{id}/{start_date}/{end_date}/', [
				'as'    =>  'service.reports.portico.tipos-vehiculos.porcentual',
				'uses'  =>  'PorticoController@serviceTipoVehiculoPorcentual'
			]);

			Route::post('/empresa/{id}/', [
				'as'    =>  'service.reports.portico.tipos-vehiculos.empresa',
				'uses'  =>  'PorticoController@serviceTipoVehiculoEmpresa'
			]);

			Route::get('/vehiculos-dia/{id}/{date}', [
				'as'    =>  'service.reports.portico.vehiculos-dia',
				'uses'  =>  'PorticoController@serviceVehiculosDia'
			]);

			Route::get('/tags/{id}/{date}', [
				'as'    =>  'service.reports.portico.tags',
				'uses'  =>  'PorticoController@serviceTags'
			]);

			Route::get('/camaras/{id}/{date}', [
				'as'    =>  'service.reports.portico.camaras',
				'uses'  =>  'PorticoController@serviceCamaras'
			]);

			Route::get('/general/{id}/{date}/{direction}', [
				'as'    =>  'service.reports.portico.general',
				'uses'  =>  'PorticoController@serviceGeneral'
			]);
		});

		Route::group([
			'prefix'    =>  'empresa'
		], function () {

			Route::post('report/{id}', [
				'as'    =>  'service.reports.empresa.report',
				'uses'  =>  'EmpresaController@serviceReport'
			]);
		});

		Route::group([
			'prefix'    =>  'vehiculo'
		], function () {

			Route::post('portico/{id}', [
				'as'    =>  'service.reports.vehiculo.portico',
				'uses'  =>  'VehiculoController@serviceVehiculoPortico'
			]);
		});
	});
});

Route::group([
	'middleware'    =>  'auth',
	'prefix'    =>  'tools'
], function () {

	Route::get('migrate', [
		'as'    =>  'tools.migrate',
		'uses'  =>  'ToolsController@migrate'
	]);
	Route::get('proincorp/migrate', [
		'as'    =>  'tools.proincorp.migrate',
		'uses'  =>  'ToolsController@command'
	]);
});

// Authentication routes...
Route::get('login', [
	'as'    =>  'auth.login.getLogin',
	'uses'  => 'Auth\AuthController@showLoginForm'
]);
Route::post('login', [
	'as'    =>  'auth.login.postLogin',
	'uses'  =>  'Auth\AuthController@login'
]);
Route::get('logout', [
	'as'    =>  'auth.logout.getLogout',
	'uses'  =>  'Auth\AuthController@logout'
]);
