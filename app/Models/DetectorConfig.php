<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Model;

class DetectorConfig extends Eloquent
{
	protected $connection = "tmsng";
	protected $table = "detectorconfiguration";

}