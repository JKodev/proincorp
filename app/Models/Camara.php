<?php
namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;

class Camara extends Eloquent
{
	protected $connection = "tmsng";
	protected $table = "detector";

	public function config()
	{
		$this->hasMany('App\Models\DectectorConfig', 'detectorId');
	}
}