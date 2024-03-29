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
					'prefix'	=>	'portico',
					'middleware'    =>  ['permission:view-portico']
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

						Route::get('/{id}/general/porcentual', [
							'as'    =>  'app.reports.portico.general.porcentual',
							'uses'  =>  'PorticoController@generalPorcentual'
						]);

						Route::get('/{id}/general/fechas', [
							'as'    =>  'app.reports.portico.general.fechas',
							'uses'  =>  'PorticoController@generalFechas'
						]);

						Route::group([
							'prefix'    =>  'avisos'
						], function () {

							Route::get('/create/{id}', [
								'as'    =>  'app.reports.portico.avisos.create',
								'uses'  =>  'AdvertisementController@create'
							]);

							Route::post('/store/{id}', [
								'as'    =>  'app.reports.portico.avisos.store',
								'uses'  =>  'AdvertisementController@store'
							]);

							Route::get('/destroy/{id}/{ad_id}', [
								'as'    =>  'app.reports.portico.avisos.destroy',
								'uses'  =>  'AdvertisementController@destroy'
							]);
						});
				});

				Route::group([
					'prefix' 	=>	'empresa',
					'middleware'    =>  ['permission:view-empresas']
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.empresa.index',
				    		'uses'	=>	'EmpresaController@index'
				    	]);

						Route::get('/{id}/report/', [
							'as'    =>  'app.reports.empresa.report',
							'uses'  =>  'EmpresaController@report'
						]);

						Route::get('/{id}/vehicles', [
							'as'    =>  'app.reports.empresa.vehicles',
							'uses'  =>  'EmpresaController@vehicles'
						]);
				});

				Route::group([
					'prefix' 	=>	'camaras',
					'middleware'    =>  ['permission:view-camaras']
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
					'prefix' 	=>	'vehiculo',
					'middleware'    =>  ['permission:view-vehiculos']
					], function() {
				    	
				    	Route::get('/', [
				    		'as'	=>	'app.reports.vehiculo.index',
				    		'uses'	=>	'VehiculoController@index'
				    	]);

						Route::get('/show', [
							'as'    =>  'app.reports.vehiculo.show',
							'uses'  =>  'VehiculoController@show'
						]);
				});

			Route::group([
				'prefix'    =>  'incidencias',
				'middleware'    =>  ['permission:view-incidencias']
			], function () {

				Route::get('/', [
					'as'    =>  'app.reports.incidencias.index',
					'uses'  =>  'IncidenciasController@index'
				]);
			});
		});

		Route::group([
			'prefix'    =>  'settings'
		], function () {
			Route::group([
				'prefix'    =>  'users',
				'middleware'    =>  ['role:admin']
			], function () {

				Route::get('/', [
					'as'    =>  'app.settings.users.index',
					'uses'  =>  'UserController@index'
				]);

				Route::get('create', [
					'as'    =>  'app.settings.users.create',
					'uses'  =>  'UserController@create'
				]);

				Route::post('/', [
					'as'    =>  'app.settings.users.store',
					'uses'  =>  'UserController@store'
				]);

				Route::get('/{id}/edit', [
					'as'    =>  'app.settings.users.edit',
					'uses'  =>  'UserController@edit'
				]);

				Route::post('/{id}/', [
					'as'    =>  'app.settings.users.update',
					'uses'  =>  'UserController@update'
				]);

				Route::get('/{id}/destroy', [
					'as'    =>  'app.settings.users.destroy',
					'uses'  =>  'UserController@destroy'
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
			'prefix'    =>  'portico',
			'middleware'    =>  ['permission:view-portico']
		], function () {

			Route::get('/porcentual/{id}/{start_date}/{end_date}/', [
				'as'    =>  'service.reports.portico.tipos-vehiculos.porcentual',
				'uses'  =>  'PorticoController@serviceTipoVehiculoPorcentual'
			]);

			Route::post('/porcentual/{id}/excel', [
				'as'    =>  'service.reports.portico.tipos-vehiculo.porcentual.excel',
				'uses'  =>  'PorticoController@serviceTipoVehiculoPorcentualExcel'
			]);

			Route::post('/empresa/{id}/', [
				'as'    =>  'service.reports.portico.tipos-vehiculos.empresa',
				'uses'  =>  'PorticoController@serviceTipoVehiculoEmpresa'
			]);

			Route::post('empresa/{id}/excel', [
				'as'    =>  'service.reports.portico.tipos-vehiculos.empresa.excel',
				'uses'  =>  'PorticoController@serviceTipoVehiculoEmpresaExcel'
			]);

			Route::get('/vehiculos-dia/{id}/{date}', [
				'as'    =>  'service.reports.portico.vehiculos-dia',
				'uses'  =>  'PorticoController@serviceVehiculosDia'
			]);

			Route::post('/vehiculos-dia/{id}/excel', [
				'as'    =>  'service.reports.portico.vehiculos-dia.excel',
				'uses'  =>  'PorticoController@serviceVehiculosDiaExcel'
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

			Route::get('/general/porcentual/{id}/{start_date}/{end_date}', [
				'as'    =>  'service.reports.portico.general.porcentual',
				'uses'  =>  'PorticoController@serviceGeneralPorcentual'
			]);

			Route::get('/general/fechas/{id}/{start_date}/{end_date}/{direction}', [
				'as'    =>  'service.reports.portico.general.fechas',
				'uses'  =>  'PorticoController@serviceGeneralFechas'
			]);
		});

		Route::group([
			'prefix'    =>  'empresa',
			'middleware'    =>  ['permission:view-empresas']
		], function () {

			Route::post('report/{id}', [
				'as'    =>  'service.reports.empresa.report',
				'uses'  =>  'EmpresaController@serviceReport'
			]);

			Route::get('find', [
				'as'    =>  'service.reports.empresa.find',
				'uses'  =>  'EmpresaController@serviceFind'
			]);
		});

		Route::group([
			'prefix'    =>  'vehiculo',
			'middleware'    =>  ['permission:view-vehiculos']
		], function () {

			Route::post('portico/{id}', [
				'as'    =>  'service.reports.vehiculo.portico',
				'uses'  =>  'VehiculoController@serviceVehiculoPortico'
			]);

			Route::get('find', [
				'as'    =>  'service.reports.vehiculo.find',
				'uses'  =>  'VehiculoController@serviceFind'
			]);

			Route::get('flow', [
				'as'    =>  'service.reports.vehiculo.flow',
				'uses'  =>  'VehiculoController@serviceFlow'
			]);
		});
	});
});

Route::group([
	'middleware'    =>  ['auth', 'role:admin'],
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
