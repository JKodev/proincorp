<?php

namespace App\Models;

use Eloquent;

class AdvertisementPictures extends Eloquent
{
	protected $dateFormat = 'd-m-Y H:i:s';
    protected $table = 'advertisement_pictures';

	public function advertisement()
	{
		return $this->belongsTo('App\Models\Advertisement');
	}
}
