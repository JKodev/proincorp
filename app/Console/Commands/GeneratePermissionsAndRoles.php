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
	    /**
	     * Creacion de Roles
	     */
	    $this->info("Se Empezara con la creación de Roles");
    	/** @var Role $admin */
        $admin = new Role();
	    $admin->name            =   "admin";
	    $admin->display_name    =   "Administrador";
	    $admin->description     =   "Administrador con total control del sistema";
	    $admin->save();

	    $this->info("Se ha creado el rol de Administrador");

        /** @var Role $supervisor */
	    $supervisor = new Role();
	    $supervisor->name            =  "supervisor";
	    $supervisor->display_name    =  "Supervisor";
	    $supervisor->description     =  "Supervisor con algunos permisos";
	    $supervisor->save();

	    $this->info("Se ha creado el rol de Supervisor");
	    $this->info("Se terminó con la creación de roles");

	    /**
	     * Creacion de Permisos
	     */
		$this->info("Se iniciará con la creación de permisos");
	    /** @var Permission $viewPortico */
	    $viewPortico = new Permission();
	    $viewPortico->name          =   "view-portico";
	    $viewPortico->display_name  =   "Ver Porticos";
	    $viewPortico->description   =   "Permite ver la lista de porticos y sus reportes";
	    $viewPortico->save();

	    $this->info("Se ha creado el permiso para 'Ver Porticos'");

	    /** @var Permission $viewEmpresas */
	    $viewEmpresas = new Permission();
	    $viewEmpresas->name         =   "view-empresas";
	    $viewEmpresas->display_name =   "Ver Empresas";
	    $viewEmpresas->description  =   "Permite ver las empresas y sus reportes";
	    $viewEmpresas->save();

	    $this->info("Se ha creado el permiso para 'Ver Empresas'");

	    /** @var Permission $viewVehiculos */
	    $viewVehiculos = new Permission();
	    $viewVehiculos->name            =   "view-vehiculos";
	    $viewVehiculos->display_name    =   "Ver Vehiculos";
	    $viewVehiculos->description     =   "Permite ver los vehiculos y sus reportes";
	    $viewVehiculos->save();

	    $this->info("Se ha creado el permiso para 'Ver Vehiculos'");

	    /** @var Permission $viewCamaras */
	    $viewCamaras = new Permission();
	    $viewCamaras->name          =   "view-camaras";
	    $viewCamaras->display_name  =   "Ver Cámaras";
	    $viewCamaras->description   =   "Permite ver las cámaras y su información";
	    $viewCamaras->save();

	    $this->info("Se ha creado el permiso para 'Ver Camaras'");

	    $this->info("Se ha terminado con la creación de permisos.");


    }
}
