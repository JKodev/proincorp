<?php

namespace App\Models;

use Eloquent;

class Advertisement extends Eloquent
{
	protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = 'advertisement';

	public function pictures()
	{
		$this->hasMany('App\Models\AdvertisementPictures');
	}
}
