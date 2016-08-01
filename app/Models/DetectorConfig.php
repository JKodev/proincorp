<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class DetectorConfig extends Model
{
	protected $connection = "tmsng";
	protected $table = "detectorconfiguration";

}