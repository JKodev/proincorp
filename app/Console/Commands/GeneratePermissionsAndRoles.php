<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;
use Monolog\Handler\RotatingFileHandler;

class GeneratePermissionsAndRoles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proincorp:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera los permisos y roles para ser utilizados para los usuarios';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    $admin_find = Role::where('name', 'admin')->count();
	    if ($admin_find == 0) {
		    $admin = new Role();
		    $admin->name            =   "admin";
		    $admin->display_name    =   "Administrador";
		    $admin->description     =   "Administrador con total control del sistema";
		    $admin->save();
	    }


	    $supervisor_find = Role::where('name', 'supervisor')->count();
	    if ($supervisor_find == 0) {
		    $supervisor = new Role();
		    $supervisor->name = "supervisor";
		    $supervisor->display_name = "Supervisor";
		    $supervisor->description = "Supervisor con algunos permisos";
		    $supervisor->save();
	    }

	    $portico_find = Permission::where('name', 'view-portico')->count();
	    if ($portico_find == 0) {
		    $viewPortico = new Permission();
		    $viewPortico->name          =   "view-portico";
		    $viewPortico->display_name  =   "Ver Porticos";
		    $viewPortico->description   =   "Permite ver la lista de porticos y sus reportes";
		    $viewPortico->save();
	    }

	    $empresas_find = Permission::where('name', 'view-empresas')->count();
	    if ($empresas_find == 0) {
		    $viewEmpresas = new Permission();
		    $viewEmpresas->name = "view-empresas";
		    $viewEmpresas->display_name = "Ver Empresas";
		    $viewEmpresas->description = "Permite ver las empresas y sus reportes";
		    $viewEmpresas->save();
	    }

	    $vehiculos_find = Permission::where('name', 'view-vehiculos')->count();
	    if ($vehiculos_find == 0) {
		    $viewVehiculos = new Permission();
		    $viewVehiculos->name = "view-vehiculos";
		    $viewVehiculos->display_name = "Ver Vehiculos";
		    $viewVehiculos->description = "Permite ver los vehiculos y sus reportes";
		    $viewVehiculos->save();
	    }

	    $camaras_find = Permission::where('name', 'view-camaras')->count();
	    if ($camaras_find == 0) {
		    $viewCamaras = new Permission();
		    $viewCamaras->name = "view-camaras";
		    $viewCamaras->display_name = "Ver Cámaras";
		    $viewCamaras->description = "Permite ver las cámaras y su información";
		    $viewCamaras->save();
	    }
    }
}
